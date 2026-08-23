import {
    IconShieldCheck,
} from "@tabler/icons-react";

import VerificationSteps
    from "../../components/verification/VerificationSteps";

import PersonalVerificationForm
    from "../../components/verification/PersonalVerificationForm";

import AddressVerificationForm
    from "../../components/verification/AddressVerificationForm";

import DocumentVerificationForm
    from "../../components/verification/DocumentVerificationForm";

import {
    useVerification,
} from "../../context/VerificationContext";


export default function Verification() {

    const {

        step,
        error,
        success,

    } = useVerification();


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

                    <VerificationSteps />


                    {
                        error && (

                            <div className="alert alert-danger">

                                {error}

                            </div>

                        )
                    }


                    {
                        success && (

                            <div className="alert alert-success">

                                {success}

                            </div>

                        )
                    }


                    {
                        step === 1 && (

                            <PersonalVerificationForm />

                        )
                    }


                    {
                        step === 2 && (

                            <AddressVerificationForm />

                        )
                    }


                    {
                        step === 3 && (

                            <DocumentVerificationForm />

                        )
                    }

                </div>

            </div>

        </div>

    );

}