import {
    IconShieldCheck,
    IconAlertTriangle,
} from "@tabler/icons-react";

import VerificationSteps
    from "../../components/verification/VerificationSteps";

import PersonalVerificationForm
    from "../../components/verification/PersonalVerificationForm";

import AddressVerificationForm
    from "../../components/verification/AddressVerificationForm";

import DocumentVerificationForm
    from "../../components/verification/DocumentVerificationForm";

import VerificationApplicationView
    from "../../components/verification/VerificationApplicationView";

import {
    useVerification,
} from "../../context/VerificationContext";


export default function Verification() {

    const {

        step,

        loading,

        error,
        success,

        verificationData,

        verificationStatus,

    } = useVerification();


    const status = Number(
        verificationStatus ?? 0
    );


    /*
    |--------------------------------------------------------------------------
    | Can edit only when status = 0
    |--------------------------------------------------------------------------
    */

    const canApply = status === 0;


    /*
    |--------------------------------------------------------------------------
    | Previous verification was cancelled/rejected
    |--------------------------------------------------------------------------
    */

    const rejectionReason =
        verificationData?.verification_description;


    return (

        <div className="page">

            <div className="container-xl">

                <div className="page-header d-print-none">

                    <div className="row align-items-center">

                        <div className="col">

                            <div className="page-pretitle">

                                Account

                            </div>

                            <h2 className="page-title">

                                <IconShieldCheck
                                    size={28}
                                    className="me-2"
                                />

                                Verification

                            </h2>

                        </div>

                    </div>

                </div>


                <div
                    className="mx-auto"
                    style={{
                        maxWidth: "800px",
                    }}
                >


                    {/*
                    |--------------------------------------------------------------------------
                    | Loading
                    |--------------------------------------------------------------------------
                    */}

                    {loading && !verificationData && (

                        <div className="text-center py-5">

                            <div
                                className="spinner-border"
                                role="status"
                            />

                        </div>

                    )}


                    {/*
                    |--------------------------------------------------------------------------
                    | ERROR
                    |--------------------------------------------------------------------------
                    */}

                    {error && (

                        <div className="alert alert-danger">

                            {error}

                        </div>

                    )}


                    {/*
                    |--------------------------------------------------------------------------
                    | SUCCESS
                    |--------------------------------------------------------------------------
                    */}

                    {success && (

                        <div className="alert alert-success">

                            {success}

                        </div>

                    )}


                    {/*
                    |--------------------------------------------------------------------------
                    | REJECTED / CANCELLED REASON
                    |
                    | Show only when:
                    | status = 0
                    | and admin has entered a reason
                    |--------------------------------------------------------------------------
                    */}

                    {canApply && rejectionReason && (

                        <div className="alert alert-danger">

                            <div className="d-flex">

                                <IconAlertTriangle
                                    size={28}
                                    className="me-3 flex-shrink-0"
                                />

                                <div>

                                    <h4 className="alert-title">

                                        Your Previous Verification Was Cancelled

                                    </h4>

                                    <div className="mb-2">

                                        Your previous verification
                                        application was not approved.
                                        Please correct the issue below
                                        and submit a new application.

                                    </div>


                                    <div
                                        className="p-3 rounded"
                                        style={{
                                            backgroundColor:
                                                "rgba(0,0,0,0.05)",
                                        }}
                                    >

                                        <strong>

                                            Reason:

                                        </strong>

                                        <div className="mt-1">

                                            {rejectionReason}

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    )}


                    {/*
                    |--------------------------------------------------------------------------
                    | STATUS = 1 OR 2
                    | Show submitted application only
                    |--------------------------------------------------------------------------
                    */}

                    {!canApply && verificationData && (

                        <VerificationApplicationView

                            data={verificationData}

                            status={status}

                        />

                    )}


                    {/*
                    |--------------------------------------------------------------------------
                    | STATUS = 0
                    | Show application form
                    |--------------------------------------------------------------------------
                    */}

                    {canApply && (

                        <>

                            <VerificationSteps />


                            {step === 1 && (

                                <PersonalVerificationForm />

                            )}


                            {step === 2 && (

                                <AddressVerificationForm />

                            )}


                            {step === 3 && (

                                <DocumentVerificationForm />

                            )}

                        </>

                    )}

                </div>

            </div>

        </div>

    );

}