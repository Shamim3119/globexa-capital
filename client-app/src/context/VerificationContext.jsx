import {
    createContext,
    useContext,
    useState,
    useEffect,
} from "react";

import api from "../api/api";
import { useAuth } from "./AuthContext";


const VerificationContext = createContext();


export function VerificationProvider({ children }) {

    const { user } = useAuth();


    /*
    |--------------------------------------------------------------------------
    | GENERAL STATE
    |--------------------------------------------------------------------------
    */

    const [step, setStep] = useState(1);

    const [loading, setLoading] = useState(false);

    const [error, setError] = useState("");

    const [success, setSuccess] = useState("");


    /*
    |--------------------------------------------------------------------------
    | VERIFICATION DATA
    |--------------------------------------------------------------------------
    */

    const [verificationData, setVerificationData] =
        useState(null);

    const [verificationStatus, setVerificationStatus] =
        useState(null);

    const [initialLoading, setInitialLoading] =
        useState(true);


    /*
    |--------------------------------------------------------------------------
    | STEP 1
    |--------------------------------------------------------------------------
    */

    const [firstName, setFirstName] = useState("");

    const [lastName, setLastName] = useState("");

    const [dateOfBirth, setDateOfBirth] = useState("");


    /*
    |--------------------------------------------------------------------------
    | STEP 2
    |--------------------------------------------------------------------------
    */

    const [address, setAddress] = useState("");

    const [postCode, setPostCode] = useState("");

    const [city, setCity] = useState("");


    /*
    |--------------------------------------------------------------------------
    | STEP 3
    |--------------------------------------------------------------------------
    |
    | IMPORTANT:
    | This is now an ARRAY.
    |
    | NID              = 2 images
    | Passport         = 1 image
    | Driving License  = 2 images
    |--------------------------------------------------------------------------
    */

    const [docType, setDocType] = useState("");

    const [docImages, setDocImages] = useState([]);


    /*
    |--------------------------------------------------------------------------
    | LOAD VERIFICATION
    |--------------------------------------------------------------------------
    */

    const loadVerification = async () => {

        if (!user?.id) {

            setInitialLoading(false);

            return;

        }


        try {

            setInitialLoading(true);

            setError("");


            const response = await api.get(
                `/verification/${user.id}`
            );


            if (response.data?.success) {

                const data = response.data.data;

                setVerificationData(data);

                setVerificationStatus(
                    Number(data.verification_status || 0)
                );


                /*
                 * Populate form data.
                 */

                setFirstName(
                    data.first_name || ""
                );

                setLastName(
                    data.last_nanme ||
                    data.last_name ||
                    ""
                );

                setDateOfBirth(
                    data.date_of_birth || ""
                );

                setAddress(
                    data.verification_address || ""
                );

                setPostCode(
                    data.post_code || ""
                );

                setCity(
                    data.city || ""
                );

                setDocType(
                    data.doc_type
                        ? String(data.doc_type)
                        : ""
                );

            }


        } catch (error) {

            console.error(
                "Load Verification Error:",
                error.response?.data || error
            );


            setError(
                error.response?.data?.message ||
                "Failed to load verification information."
            );


        } finally {

            setInitialLoading(false);

        }

    };


    /*
    |--------------------------------------------------------------------------
    | LOAD ON USER CHANGE
    |--------------------------------------------------------------------------
    */

    useEffect(() => {

        if (user?.id) {

            loadVerification();

        } else {

            setInitialLoading(false);

        }

    }, [user?.id]);


    /*
    |--------------------------------------------------------------------------
    | CHECK IF EDITING IS ALLOWED
    |--------------------------------------------------------------------------
    */

    const canEdit =
        Number(verificationStatus) === 0;


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


        if (!canEdit) {

            setError(
                "Verification has already been submitted. Editing is not allowed."
            );

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


            const response = await api.put(

                `/verification/${user.id}/step-1`,

                {
                    first_name: firstName,

                    last_name: lastName,

                    date_of_birth: dateOfBirth,
                }

            );


            if (response.data?.success) {

                setSuccess(
                    response.data?.message ||
                    "Personal information saved successfully."
                );


                setVerificationData(
                    response.data?.data ||
                    verificationData
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


            const errors =
                error.response?.data?.errors;


            if (errors) {

                const firstError = Object.values(errors)
                    .flat()
                    .shift();

                setError(
                    firstError ||
                    error.response?.data?.message ||
                    "Failed to save personal information."
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

/*
|--------------------------------------------------------------------------
| STEP 2 SUBMIT
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| STEP 2 SUBMIT
|--------------------------------------------------------------------------
*/

    const submitStep2 = async (formDataPayload) => {

        if (!user?.id) {

            setError("User not found.");

            return false;

        }


        if (!canEdit) {

            setError(
                "Verification has already been submitted. Editing is not allowed."
            );

            return false;

        }

        const currentAddress = String(formDataPayload?.address ?? address ?? "");
        const currentPostCode = String(formDataPayload?.postCode ?? postCode ?? "");
        const currentCity = String(formDataPayload?.city ?? city ?? "");


        if (
            !currentAddress.trim() ||
            !currentPostCode.trim() ||
            !currentCity.trim()
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
                    verification_address: currentAddress,

                    post_code: currentPostCode,

                    city: currentCity,
                }

            );


            if (response.data?.success) {

                setSuccess(
                    response.data?.message ||
                    "Address information saved successfully."
                );


                setVerificationData(
                    response.data?.data ||
                    verificationData
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


            const errors =
                error.response?.data?.errors;


            if (errors) {

                const firstError = Object.values(errors)
                    .flat()
                    .shift();

                setError(
                    firstError ||
                    error.response?.data?.message ||
                    "Failed to save address information."
                );

            } else {

                setError(
                    error.response?.data?.message ||
                    "Failed to save address information."
                );

            }


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


        const requiresBothSides =
            Number(docType) === 1 ||
            Number(docType) === 3;


        if (docImages.length === 0) {

            setError(
                "Please upload your verification document."
            );

            return false;

        }


        if (
            requiresBothSides &&
            docImages.length < 2
        ) {

            setError(
                "Please upload both front and back sides of your document."
            );

            return false;

        }


        if (
            Number(docType) === 2 &&
            docImages.length !== 1
        ) {

            setError(
                "Please upload only one image for Passport."
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
                docType
            );


            /*
            * Append all images.
            *
            * Laravel receives:
            * doc_images[]
            */
            docImages.forEach((image) => {

                formData.append(
                    "doc_images[]",
                    image
                );

            });


            const response = await api.post(

                `/verification/${user.id}/step-3`,

                formData

            );


            if (response.data?.success) {

                setSuccess(
                    response.data?.message ||
                    "Verification submitted successfully."

                );

                await loadVerification();

                return true;

            }


            setError(
                response.data?.message ||
                "Failed to submit verification."
            );

            return false;


        } catch (error) {

            console.error(
                "Verification Step 3 Error:",
                error.response?.data || error
            );


            const validationErrors =
                error.response?.data?.errors;


            if (validationErrors) {

                const firstError = Object.values(
                    validationErrors
                )[0]?.[0];


                setError(
                    firstError ||
                    "Validation failed."
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

        setDocImages([]);


        setError("");

        setSuccess("");

    };


    /*
    |--------------------------------------------------------------------------
    | CONTEXT VALUE
    |--------------------------------------------------------------------------
    */

    return (

        <VerificationContext.Provider

            value={{

                /*
                 * General
                 */

                step,
                setStep,

                loading,

                initialLoading,

                error,
                setError,

                success,
                setSuccess,


                /*
                 * Verification data
                 */

                verificationData,

                verificationStatus,

                setVerificationStatus,

                loadVerification,

                canEdit,


                /*
                 * Step 1
                 */

                firstName,
                setFirstName,

                lastName,
                setLastName,

                dateOfBirth,
                setDateOfBirth,


                /*
                 * Step 2
                 */

                address,
                setAddress,

                postCode,
                setPostCode,

                city,
                setCity,


                /*
                 * Step 3
                 *
                 * IMPORTANT:
                 * Array, not single docImage
                 */

                docType,
                setDocType,

                docImages,
                setDocImages,


                /*
                 * Actions
                 */

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