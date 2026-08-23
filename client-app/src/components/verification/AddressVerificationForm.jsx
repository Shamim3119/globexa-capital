import {
    IconMapPin,
    IconArrowLeft,
    IconArrowRight,
    IconLoader2,
} from "@tabler/icons-react";

import {
    useVerification,
} from "../../context/VerificationContext";


export default function AddressVerificationForm() {

    const {

        address,
        setAddress,

        postCode,
        setPostCode,

        city,
        setCity,

        loading,

        submitStep2,
        previousStep,

    } = useVerification();


    const handleSubmit = async (e) => {

        e.preventDefault();

        console.log("Submitting Step 2...");


        const result = await submitStep2();


        console.log(
            "Step 2 Result:",
            result
        );

    };


    return (

        <div className="card">

            <div className="card-header">

                <h3 className="card-title">

                    <IconMapPin
                        size={20}
                        className="me-2"
                    />

                    Address Information

                </h3>

            </div>


            <form onSubmit={handleSubmit}>

                <div className="card-body">


                    {/* Address */}

                    <div className="mb-3">

                        <label className="form-label">

                            Address

                        </label>


                        <textarea

                            className="form-control"

                            rows="3"

                            placeholder="Enter your full address"

                            value={address}

                            onChange={(e) =>
                                setAddress(
                                    e.target.value
                                )
                            }

                            disabled={loading}

                        />

                    </div>


                    {/* Post Code */}

                    <div className="mb-3">

                        <label className="form-label">

                            Post Code

                        </label>


                        <input

                            type="text"

                            className="form-control"

                            placeholder="Enter post code"

                            value={postCode}

                            onChange={(e) =>
                                setPostCode(
                                    e.target.value
                                )
                            }

                            disabled={loading}

                        />

                    </div>


                    {/* City */}

                    <div className="mb-3">

                        <label className="form-label">

                            City

                        </label>


                        <input

                            type="text"

                            className="form-control"

                            placeholder="Enter city"

                            value={city}

                            onChange={(e) =>
                                setCity(
                                    e.target.value
                                )
                            }

                            disabled={loading}

                        />

                    </div>

                </div>


                <div className="card-footer">

                    <div className="d-flex justify-content-between">


                        {/* Previous Button */}

                        <button

                            type="button"

                            className="btn btn-outline-secondary"

                            onClick={previousStep}

                            disabled={loading}

                        >

                            <IconArrowLeft
                                size={18}
                                className="me-2"
                            />

                            Previous

                        </button>


                        {/* Next Button */}

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

                </div>

            </form>

        </div>

    );

}