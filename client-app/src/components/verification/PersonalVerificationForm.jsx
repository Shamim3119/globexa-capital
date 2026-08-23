import {
    IconUser,
    IconArrowRight,
    IconLoader2,
} from "@tabler/icons-react";

import {
    useVerification,
} from "../../context/VerificationContext";


export default function PersonalVerificationForm() {

    const {

        firstName,
        setFirstName,

        lastName,
        setLastName,

        dateOfBirth,
        setDateOfBirth,

        loading,

        submitStep1,

    } = useVerification();


    const handleSubmit = async (e) => {

        e.preventDefault();

        console.log("Submitting Step 1...");

        const result = await submitStep1();

        console.log(
            "Step 1 Result:",
            result
        );

    };


    return (

        <div className="card">

            <div className="card-header">

                <h3 className="card-title">

                    <IconUser
                        size={20}
                        className="me-2"
                    />

                    Personal Information

                </h3>

            </div>


            <form onSubmit={handleSubmit}>

                <div className="card-body">


                    {/* First Name */}

                    <div className="mb-3">

                        <label className="form-label">

                            First Name

                        </label>


                        <input

                            type="text"

                            className="form-control"

                            placeholder="Enter first name"

                            value={firstName}

                            onChange={(e) =>
                                setFirstName(
                                    e.target.value
                                )
                            }

                            disabled={loading}

                        />

                    </div>


                    {/* Last Name */}

                    <div className="mb-3">

                        <label className="form-label">

                            Last Name

                        </label>


                        <input

                            type="text"

                            className="form-control"

                            placeholder="Enter last name"

                            value={lastName}

                            onChange={(e) =>
                                setLastName(
                                    e.target.value
                                )
                            }

                            disabled={loading}

                        />

                    </div>


                    {/* Date of Birth */}

                    <div className="mb-3">

                        <label className="form-label">

                            Date of Birth

                        </label>


                        <input

                            type="date"

                            className="form-control"

                            value={dateOfBirth}

                            onChange={(e) =>
                                setDateOfBirth(
                                    e.target.value
                                )
                            }

                            disabled={loading}

                        />

                    </div>


                </div>


                <div className="card-footer text-end">

                    <button

                        type="submit"

                        className="btn btn-primary"

                        disabled={loading}

                    >

                        {
                            loading ? (

                                <>

                                    <IconLoader2
                                        size={18}
                                        className="me-2 spinner-border spinner-border-sm"
                                    />

                                    Saving...

                                </>

                            ) : (

                                <>

                                    Next Step

                                    <IconArrowRight
                                        size={18}
                                        className="ms-2"
                                    />

                                </>

                            )
                        }

                    </button>

                </div>

            </form>

        </div>

    );

}