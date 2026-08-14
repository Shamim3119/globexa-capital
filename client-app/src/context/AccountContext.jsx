import {
    createContext,
    useContext,
    useEffect,
    useState,
} from "react";

import api from "../api/api";
import { useAuth } from "./AuthContext";


const AccountContext = createContext(null);


export function AccountProvider({ children }) {

    const { user } = useAuth();

    const [accounts, setAccounts] = useState([]);

    const [operators, setOperators] = useState([]);

    const [id, setId] = useState(null);

    const [accountName, setAccountName] = useState("");

    const [accountNo, setAccountNo] = useState("");

    const [operatorId, setOperatorId] = useState("");

    const [inactive, setInactive] = useState(false);

    const [loading, setLoading] = useState(false);

    const [accountsLoading, setAccountsLoading] = useState(false);

    const [operatorsLoading, setOperatorsLoading] = useState(false);

    const [error, setError] = useState(null);


    /*
    |--------------------------------------------------------------------------
    | Load Operators
    |--------------------------------------------------------------------------
    */

    const loadOperators = async () => {

        try {

            setOperatorsLoading(true);

            const response = await api.get(
                "/bank-operators"
            );

            const data = response.data?.data || [];

            setOperators(data);

            // Same default behavior as React Native
            if (data.length > 0 && !operatorId) {

                setOperatorId(
                    String(data[0].id)
                );

            }

        } catch (error) {

            console.error(
                "Bank Operators Error:",
                error.response?.data || error
            );

            setError(
                error.response?.data?.message ||
                "Failed to load payment operators."
            );

        } finally {

            setOperatorsLoading(false);

        }

    };


    /*
    |--------------------------------------------------------------------------
    | Load Accounts
    |--------------------------------------------------------------------------
    */

    const loadAccounts = async () => {

        if (!user?.id) {
            return;
        }

        try {

            setAccountsLoading(true);

            const response = await api.get(
                "/client-accounts",
                {
                    params: {
                        client_id: user.id,
                    },
                }
            );

            setAccounts(
                response.data?.data || []
            );

        } catch (error) {

            console.error(
                "Accounts Error:",
                error.response?.data || error
            );

            setError(
                error.response?.data?.message ||
                "Failed to load accounts."
            );

        } finally {

            setAccountsLoading(false);

        }

    };


    /*
    |--------------------------------------------------------------------------
    | Reset Form
    |--------------------------------------------------------------------------
    */

    const resetForm = () => {

        setId(null);

        setAccountName("");

        setAccountNo("");

        setOperatorId(
            operators.length > 0
                ? String(operators[0].id)
                : ""
        );

        setInactive(false);

    };


    /*
    |--------------------------------------------------------------------------
    | Save Account
    |--------------------------------------------------------------------------
    */

    const saveAccount = async () => {

        if (!user?.id) {

            return {
                success: false,
                message: "User not found.",
            };

        }


        if (!accountName.trim()) {

            return {
                success: false,
                message: "Account name is required.",
            };

        }


        if (!accountNo.trim()) {

            return {
                success: false,
                message: "Account number is required.",
            };

        }


        if (!operatorId) {

            return {
                success: false,
                message: "Payment operator is required.",
            };

        }


        try {

            setLoading(true);

            setError(null);


            await api.post(
                "/client-accounts",
                {
                    id: id,
                    client_id: user.id,
                    account_name: accountName.trim(),
                    account_no: accountNo.trim(),
                    operator_id: Number(operatorId),
                    inactive: inactive ? 1 : 0,
                }
            );


            await loadAccounts();


            const message = id
                ? "Account updated successfully."
                : "Account created successfully.";


            resetForm();


            return {
                success: true,
                message,
            };


        } catch (error) {

            console.error(
                "Save Account Error:",
                error.response?.data || error
            );


            const message =
                error.response?.data?.message ||
                "Failed to save account.";


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
    | Edit Account
    |--------------------------------------------------------------------------
    */

    const editAccount = (account) => {

        setId(account.id);

        setAccountName(
            account.account_name || ""
        );

        setAccountNo(
            account.account_no || ""
        );

        setOperatorId(
            String(account.operator_id || "")
        );

        setInactive(
            Number(account.inactive) === 1
        );

    };


    /*
    |--------------------------------------------------------------------------
    | Selected Operator
    |--------------------------------------------------------------------------
    */

    const selectedOperator =
        operators.find(
            (operator) =>
                String(operator.id) ===
                String(operatorId)
        ) || null;


    /*
    |--------------------------------------------------------------------------
    | Initial Loading
    |--------------------------------------------------------------------------
    */

    useEffect(() => {

        if (!user?.id) {
            return;
        }

        loadOperators();

        loadAccounts();

    }, [user?.id]);


    return (

        <AccountContext.Provider
            value={{

                accounts,
                operators,

                id,
                setId,

                accountName,
                setAccountName,

                accountNo,
                setAccountNo,

                operatorId,
                setOperatorId,

                inactive,
                setInactive,

                selectedOperator,

                loading,
                accountsLoading,
                operatorsLoading,

                error,

                saveAccount,
                editAccount,
                resetForm,

                loadAccounts,
                loadOperators,

            }}
        >

            {children}

        </AccountContext.Provider>

    );

}


export function useAccount() {

    const context = useContext(AccountContext);

    if (!context) {

        throw new Error(
            "useAccount must be used inside AccountProvider"
        );

    }

    return context;

}