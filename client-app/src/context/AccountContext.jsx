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


    /*
    |--------------------------------------------------------------------------
    | Accounts
    |--------------------------------------------------------------------------
    */

    const [accounts, setAccounts] = useState([]);

    const [accountsLoading, setAccountsLoading] =
        useState(false);


    /*
    |--------------------------------------------------------------------------
    | Banking Types
    |--------------------------------------------------------------------------
    */

    const [bankingTypes, setBankingTypes] =
        useState([]);

    const [bankingTypeId, setBankingTypeId] =
        useState("");


    /*
    |--------------------------------------------------------------------------
    | Payment Operators
    |--------------------------------------------------------------------------
    */

    const [operators, setOperators] =
        useState([]);

    const [operatorId, setOperatorId] =
        useState("");

    const [operatorsLoading, setOperatorsLoading] =
        useState(false);


    /*
    |--------------------------------------------------------------------------
    | Account Form
    |--------------------------------------------------------------------------
    */

    const [id, setId] = useState(null);

    const [accountName, setAccountName] =
        useState("");

    const [accountNo, setAccountNo] =
        useState("");

    const [branch, setBranch] =
        useState("");

    const [inactive, setInactive] =
        useState(false);


    /*
    |--------------------------------------------------------------------------
    | General Loading / Error
    |--------------------------------------------------------------------------
    */

    const [loading, setLoading] =
        useState(false);

    const [error, setError] =
        useState(null);


    /*
    |--------------------------------------------------------------------------
    | Load Banking Types
    |--------------------------------------------------------------------------
    */

    const loadBankingTypes = async () => {

        try {

            const response =
                await api.get(
                    "/parameters",
                    {
                        params: {
                            tag: "banking-type",
                        },
                    }
                );


            const data =
                response.data?.data || [];


            setBankingTypes(data);


            /*
            |--------------------------------------------------------------------------
            | Select first banking type
            |--------------------------------------------------------------------------
            */

            if (data.length > 0) {

                setBankingTypeId(
                    String(data[0].id)
                );

            }

        } catch (error) {

            console.error(
                "Banking Types Error:",
                error.response?.data || error
            );


            setError(
                error.response?.data?.message ||
                "Failed to load banking types."
            );

        }

    };


    /*
    |--------------------------------------------------------------------------
    | Load Operators
    |--------------------------------------------------------------------------
    */

    const loadOperators = async () => {

        try {

            setOperatorsLoading(true);


            const response =
                await api.get(
                    "/bank-operators"
                );


            const data =
                response.data?.data || [];


            setOperators(data);


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
    | Filter Operators By Banking Type
    |--------------------------------------------------------------------------
    */

    const filteredOperators =
        operators.filter(
            (operator) =>
                String(operator.type_id) ===
                String(bankingTypeId)
        );


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
    | Banking Type Change
    |--------------------------------------------------------------------------
    */

    const handleBankingTypeChange = (value) => {

        setBankingTypeId(
            String(value)
        );


        /*
        |--------------------------------------------------------------------------
        | Clear previous operator
        |--------------------------------------------------------------------------
        */

        setOperatorId("");

        setBranch("");

    };


    /*
    |--------------------------------------------------------------------------
    | Operator Change
    |--------------------------------------------------------------------------
    */

    const handleOperatorChange = (value) => {

        const newOperatorId =
            String(value);


        setOperatorId(
            newOperatorId
        );


        const operator =
            operators.find(
                (item) =>
                    String(item.id) ===
                    newOperatorId
            );


        /*
        |--------------------------------------------------------------------------
        | Clear branch when type is not 7
        |--------------------------------------------------------------------------
        */

        if (
            Number(operator?.type_id) !== 7
        ) {

            setBranch("");

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


            const response =
                await api.get(
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

        setBranch("");

        /*
        | Reset to first banking type
        */

        if (bankingTypes.length > 0) {

            setBankingTypeId(
                String(bankingTypes[0].id)
            );

        } else {

            setBankingTypeId("");

        }


        /*
        | Clear operator first
        */

        setOperatorId("");


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
                message:
                    "Account name is required.",
            };

        }


        if (!accountNo.trim()) {

            return {
                success: false,
                message:
                    "Account number is required.",
            };

        }


        if (!bankingTypeId) {

            return {
                success: false,
                message:
                    "Banking type is required.",
            };

        }


        if (!operatorId) {

            return {
                success: false,
                message:
                    "Payment operator is required.",
            };

        }


        /*
        |--------------------------------------------------------------------------
        | Branch Validation
        |--------------------------------------------------------------------------
        */

        if (
            Number(selectedOperator?.type_id) === 7 &&
            !branch.trim()
        ) {

            return {
                success: false,
                message:
                    "Branch is required for this payment operator.",
            };

        }


        try {

            setLoading(true);

            setError(null);


            await api.post(
                "/client-accounts",
                {
                    id: id,

                    client_id:
                        user.id,

                    account_name:
                        accountName.trim(),

                    account_no:
                        accountNo.trim(),

                    operator_id:
                        Number(operatorId),

                    branch:
                        Number(
                            selectedOperator?.type_id
                        ) === 7
                            ? branch.trim()
                            : null,

                    inactive:
                        inactive ? 1 : 0,
                }
            );


            /*
            |--------------------------------------------------------------------------
            | Reload List
            |--------------------------------------------------------------------------
            */

            await loadAccounts();


            const message =
                id
                    ? "Account updated successfully."
                    : "Account created successfully.";


            /*
            |--------------------------------------------------------------------------
            | Reset Form
            |--------------------------------------------------------------------------
            */

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


        setBranch(
            account.branch || ""
        );


        setOperatorId(
            String(account.operator_id || "")
        );


        /*
        |--------------------------------------------------------------------------
        | Set Banking Type From Operator
        |--------------------------------------------------------------------------
        */

        if (account.operator?.type_id) {

            setBankingTypeId(
                String(
                    account.operator.type_id
                )
            );

        }


        setInactive(
            Number(account.inactive) === 1
        );

    };


    /*
    |--------------------------------------------------------------------------
    | Initial Loading
    |--------------------------------------------------------------------------
    */

    useEffect(() => {

        if (!user?.id) {
            return;
        }


        loadBankingTypes();

        loadOperators();

        loadAccounts();

    }, [user?.id]);


    /*
    |--------------------------------------------------------------------------
    | Context Provider
    |--------------------------------------------------------------------------
    */

    return (

        <AccountContext.Provider
            value={{

                /*
                | Accounts
                */

                accounts,

                accountsLoading,

                loadAccounts,


                /*
                | Banking Types
                */

                bankingTypes,

                bankingTypeId,

                setBankingTypeId,

                filteredOperators,

                handleBankingTypeChange,


                /*
                | Operators
                */

                operators,

                selectedOperator,

                operatorId,

                setOperatorId,

                handleOperatorChange,

                operatorsLoading,


                /*
                | Form
                */

                id,

                setId,

                accountName,

                setAccountName,

                accountNo,

                setAccountNo,

                branch,

                setBranch,

                inactive,

                setInactive,


                /*
                | State
                */

                loading,

                error,


                /*
                | Actions
                */

                saveAccount,

                editAccount,

                resetForm,

                loadOperators,

                loadBankingTypes,

            }}
        >

            {children}

        </AccountContext.Provider>

    );

}


/*
|--------------------------------------------------------------------------
| Hook
|--------------------------------------------------------------------------
*/

export function useAccount() {

    const context =
        useContext(AccountContext);


    if (!context) {

        throw new Error(
            "useAccount must be used inside AccountProvider"
        );

    }


    return context;

}