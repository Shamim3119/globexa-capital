import {
    createContext,
    useContext,
    useState,
} from "react";

import api from "../api/api";
import { useAuth } from "./AuthContext";


const VerificationContext = createContext();


export function VerificationProvider({ children }) {

    const { user } = useAuth();


    const [step, setStep] = useState(1);

    const [loading, setLoading] = useState(false);
    const [error, setError] = useState("");
    const [success, setSuccess] = useState("");


    // STEP 1

    const [firstName, setFirstName] = useState("");
    const [lastName, setLastName] = useState("");
    const [dateOfBirth, setDateOfBirth] = useState("");


    // STEP 2

    const [address, setAddress] = useState("");
    const [postCode, setPostCode] = useState("");
    const [city, setCity] = useState("");


    // STEP 3

    const [docType, setDocType] = useState("");
    const [docImage, setDocImage] = useState(null);


    /*
    |--------------------------------------------------------------------------
    | STEP 1 SUBMIT
    |--------------------------------------------------------------------------
    */

    const submitStep1 = async () => {

        if (!user?.id) {

            setError("User not found.");

            return false;

        }


        if (
            !firstName.trim() ||
            !lastName.trim() ||
            !dateOfBirth
        ) {

            setError(
                "Please complete all personal information."
            );

            return false;

        }


        try {

            setLoading(true);
            setError("");
            setSuccess("");


            const payload = {

                first_name: firstName.trim(),

                last_name: lastName.trim(),

                date_of_birth: dateOfBirth,

            };


            console.log(
                "Sending Step 1:",
                payload
            );


            const response = await api.put(

                `/verification/${user.id}/step-1`,

                payload

            );


            console.log(
                "Step 1 Response:",
                response.data
            );


            if (response.data?.success) {

                setSuccess(
                    response.data?.message ||
                    "Personal information saved successfully."
                );

                setStep(2);

                return true;

            }


            setError(
                response.data?.message ||
                "Failed to save personal information."
            );

            return false;


        } catch (error) {

            console.error(
                "Verification Step 1 Error:",
                error.response?.data || error
            );


            const responseErrors =
                error.response?.data?.errors;


            if (responseErrors) {

                setError(
                    Object.values(responseErrors)
                        .flat()
                        .join(" ")
                );

            } else {

                setError(
                    error.response?.data?.message ||
                    "Failed to save personal information."
                );

            }


            return false;


        } finally {

            setLoading(false);

        }

    };


    /*
    |--------------------------------------------------------------------------
    | STEP 2 SUBMIT
    |--------------------------------------------------------------------------
    */

    const submitStep2 = async () => {

        if (!user?.id) {

            setError("User not found.");
            return false;

        }


        if (
            !address.trim() ||
            !postCode.trim() ||
            !city.trim()
        ) {

            setError(
                "Please complete all address information."
            );

            return false;

        }


        try {

            setLoading(true);
            setError("");
            setSuccess("");


            const response = await api.put(

                `/verification/${user.id}/step-2`,

                {
                    verification_address: address,
                    post_code: postCode,
                    city: city,
                }

            );


            if (response.data?.success) {

                setSuccess(
                    response.data?.message ||
                    "Address information saved successfully."
                );


                setStep(3);

                return true;

            }


            setError(
                response.data?.message ||
                "Failed to save address information."
            );

            return false;


        } catch (error) {

            console.error(
                "Verification Step 2 Error:",
                error.response?.data || error
            );


            setError(

                error.response?.data?.message ||
                "Failed to save address information."

            );

            return false;


        } finally {

            setLoading(false);

        }

    };


    /*
    |--------------------------------------------------------------------------
    | STEP 3 SUBMIT
    |--------------------------------------------------------------------------
    */

    const submitStep3 = async () => {

        if (!user?.id) {

            setError("User not found.");

            return false;

        }


        if (!docType) {

            setError(
                "Please select a document type."
            );

            return false;

        }


        if (!docImage) {

            setError(
                "Please upload your verification document."
            );

            return false;

        }


        try {

            setLoading(true);
            setError("");
            setSuccess("");


            const formData = new FormData();


            formData.append(
                "doc_type",
                String(docType)
            );


            formData.append(
                "doc_img",
                docImage
            );


            console.log(
                "Submitting Step 3:",
                {
                    clientId: user.id,
                    docType: docType,
                    docImage: docImage,
                }
            );


            const response = await api.post(

                `/verification/${user.id}/step-3`,

                formData

            );


            console.log(
                "Step 3 Response:",
                response.data
            );


            if (response.data?.success) {

                setSuccess(
                    response.data?.message ||
                    "Verification completed successfully."
                );

                return true;

            }


            setError(
                response.data?.message ||
                "Failed to upload verification document."
            );

            return false;


        } catch (error) {

            console.error(
                "Verification Step 3 Error:",
                error.response?.data || error
            );


            const responseErrors =
                error.response?.data?.errors;


            if (responseErrors) {

                setError(
                    Object.values(responseErrors)
                        .flat()
                        .join(" ")
                );

            } else {

                setError(
                    error.response?.data?.message ||
                    "Failed to upload verification document."
                );

            }


            return false;


        } finally {

            setLoading(false);

        }

    };


    /*
    |--------------------------------------------------------------------------
    | PREVIOUS STEP
    |--------------------------------------------------------------------------
    */

    const previousStep = () => {

        setError("");
        setSuccess("");


        setStep((currentStep) =>
            Math.max(currentStep - 1, 1)
        );

    };


    /*
    |--------------------------------------------------------------------------
    | RESET
    |--------------------------------------------------------------------------
    */

    const resetVerification = () => {

        setStep(1);


        setFirstName("");
        setLastName("");
        setDateOfBirth("");


        setAddress("");
        setPostCode("");
        setCity("");


        setDocType("");
        setDocImage(null);


        setError("");
        setSuccess("");

    };


    return (

        <VerificationContext.Provider

            value={{

                step,
                setStep,


                loading,
                error,
                success,


                // STEP 1

                firstName,
                setFirstName,

                lastName,
                setLastName,

                dateOfBirth,
                setDateOfBirth,


                // STEP 2

                address,
                setAddress,

                postCode,
                setPostCode,

                city,
                setCity,


                // STEP 3

                docType,
                setDocType,

                docImage,
                setDocImage,


                // ACTIONS

                submitStep1,
                submitStep2,
                submitStep3,

                previousStep,

                resetVerification,

            }}

        >

            {children}

        </VerificationContext.Provider>

    );

}


export function useVerification() {

    const context = useContext(
        VerificationContext
    );


    if (!context) {

        throw new Error(
            "useVerification must be used inside VerificationProvider"
        );

    }


    return context;

}