import { useVerification } from "../../context/VerificationContext";


export default function VerificationSteps() {

    const { step } = useVerification();


    const steps = [
        "Personal",
        "Address",
        "Document",
    ];


    return (

        <div className="d-flex align-items-center justify-content-between mb-4">

            {steps.map((name, index) => {

                const stepNumber = index + 1;

                const active =
                    step === stepNumber;

                const completed =
                    step > stepNumber;


                return (

                    <div
                        key={stepNumber}
                        className="d-flex flex-column align-items-center flex-fill position-relative"
                    >

                        <div
                            className={`
                                rounded-circle
                                d-flex
                                align-items-center
                                justify-content-center
                                fw-bold
                                ${
                                    active || completed
                                        ? "bg-primary text-white"
                                        : "bg-secondary-lt text-secondary"
                                }
                            `}
                            style={{
                                width: "42px",
                                height: "42px",
                            }}
                        >

                            {completed
                                ? "✓"
                                : stepNumber}

                        </div>


                        <div
                            className={`
                                mt-2
                                small
                                text-center
                                ${
                                    active
                                        ? "fw-bold text-primary"
                                        : "text-secondary"
                                }
                            `}
                        >

                            {name}

                        </div>

                    </div>

                );

            })}

        </div>

    );

}