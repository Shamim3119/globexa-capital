import {
    createContext,
    useContext,
    useEffect,
    useState,
} from "react";

import api from "../api/api";
import { useAuth } from "./AuthContext";

const InvestmentContext = createContext();

export function InvestmentProvider({ children }) {

    const { user } = useAuth();

    const [investments, setInvestments] = useState([]);
    const [plans, setPlans] = useState([]);

    const [investmentId, setInvestmentId] = useState("");
    const [amount, setAmount] = useState("");

    const [depositBalance, setDepositBalance] = useState(0);

    const [loading, setLoading] = useState(false);
    const [plansLoading, setPlansLoading] = useState(true);
    const [investmentsLoading, setInvestmentsLoading] = useState(true);

    const [error, setError] = useState(null);


    useEffect(() => {

        if (!user?.id) {
            return;
        }

        loadPlans();
        loadInvestments();

    }, [user?.id]);


    /*
    |--------------------------------------------------------------------------
    | Load Investment Plans
    |--------------------------------------------------------------------------
    */

    const loadPlans = async () => {

        if (!user?.id) {
            return;
        }

        try {

            setPlansLoading(true);

            const res = await api.get(
                "/deposite-commissions",
                {
                    params: {
                        client_id: user.id,
                    },
                }
            );


            const data = res.data?.data || [];

            setPlans(data);


            /*
             * Deposit balance can come from response root
             * or first plan item.
             */

            if (res.data?.deposit_balance !== undefined) {

                setDepositBalance(
                    Number(res.data.deposit_balance)
                );

            } else if (data.length > 0) {

                setDepositBalance(
                    Number(data[0]?.deposit_balance || 0)
                );

            }


            /*
             * Select first plan automatically.
             */

            if (data.length > 0) {

                setInvestmentId(
                    String(data[0].id)
                );

            }

        } catch (error) {

            console.error(
                "Investment Plans Error:",
                error.response?.data || error
            );

            setError(
                error.response?.data?.message ||
                "Failed to load investment plans."
            );

        } finally {

            setPlansLoading(false);

        }

    };


    /*
    |--------------------------------------------------------------------------
    | Load Investments
    |--------------------------------------------------------------------------
    */

    const loadInvestments = async () => {

        if (!user?.id) {
            return;
        }

        try {

            setInvestmentsLoading(true);

            const res = await api.get(
                "/investment",
                {
                    params: {
                        client_id: user.id,
                    },
                }
            );


            setInvestments(
                res.data?.data || []
            );

        } catch (error) {

            console.error(
                "Investment History Error:",
                error.response?.data || error
            );

            setError(
                error.response?.data?.message ||
                "Failed to load investments."
            );

        } finally {

            setInvestmentsLoading(false);

        }

    };


    /*
    |--------------------------------------------------------------------------
    | Reset Form
    |--------------------------------------------------------------------------
    */

    const resetForm = () => {

        setAmount("");

        if (plans.length > 0) {

            setInvestmentId(
                String(plans[0].id)
            );

        } else {

            setInvestmentId("");

        }

    };


    /*
    |--------------------------------------------------------------------------
    | Save Investment
    |--------------------------------------------------------------------------
    */

    const saveInvestment = async () => {

        if (!user?.id) {

            return {
                success: false,
                message: "User not found.",
            };

        }


        if (!amount.trim()) {

            return {
                success: false,
                message: "Amount is required.",
            };

        }


        if (!investmentId) {

            return {
                success: false,
                message: "Please select an investment plan.",
            };

        }


        const amt = Number(amount);


        if (isNaN(amt) || amt <= 0) {

            return {
                success: false,
                message: "Please enter a valid amount.",
            };

        }


        if (amt > depositBalance) {

            return {
                success: false,
                message:
                    "Amount cannot be greater than deposit balance.",
            };

        }


        try {

            setLoading(true);
            setError(null);


            const res = await api.post(
                "/investment",
                {
                    client_id: user.id,
                    investment_id: Number(investmentId),
                    amount: amt,
                }
            );


            /*
             * Refresh balance and history.
             */

            await loadPlans();
            await loadInvestments();

            resetForm();


            return {
                success: true,
                message:
                    res.data?.message ||
                    "Investment created successfully.",
            };

        } catch (error) {

            console.error(
                "Investment Error:",
                error.response?.data || error
            );


            const message =
                error.response?.data?.message ||
                "Unable to save investment.";


            setError(message);


            return {
                success: false,
                message,
            };

        } finally {

            setLoading(false);

        }

    };


    /*
    |--------------------------------------------------------------------------
    | Calculate Commission
    |--------------------------------------------------------------------------
    */

    const selectedPlan = plans.find(
        (plan) =>
            String(plan.id) === String(investmentId)
    );


    const commission = selectedPlan
        ? (
            Number(amount || 0) *
            Number(selectedPlan.deposite_commission || 0)
        ) / 100
        : 0;


    /*
    |--------------------------------------------------------------------------
    | Plan Name
    |--------------------------------------------------------------------------
    */

    const planName = (planId) => {

        const plan = plans.find(
            (item) =>
                String(item.id) === String(planId)
        );


        if (!plan) {
            return "";
        }


        return `${plan.day} Days - ${plan.deposite_commission}%`;

    };


    return (

        <InvestmentContext.Provider
            value={{

                investments,
                plans,

                investmentId,
                setInvestmentId,

                amount,
                setAmount,

                depositBalance,

                selectedPlan,
                commission,

                planName,

                loading,
                plansLoading,
                investmentsLoading,

                error,

                saveInvestment,
                loadPlans,
                loadInvestments,
                resetForm,

            }}
        >

            {children}

        </InvestmentContext.Provider>

    );

}


export function useInvestment() {

    return useContext(InvestmentContext);

}