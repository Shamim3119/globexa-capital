import {
    IconClockHour4,
    IconCircleCheck,
    IconUser,
    IconMapPin,
    IconFileDescription,
    IconPhoto,
} from "@tabler/icons-react";


export default function VerificationApplicationView({
    data,
    status,
}) {

    const isPending = Number(status) === 2;
    const isApproved = Number(status) === 1;


    const documentTypes = {
        1: "NID",
        2: "Passport",
        3: "Driving License",
    };


    /*
    |--------------------------------------------------------------------------
    | Document Images
    |--------------------------------------------------------------------------
    */

    const documentImages =
        Array.isArray(data?.doc_image_urls)
            ? data.doc_image_urls
            : [];


    return (

        <div className="row row-cards">


            {/* STATUS CARD */}

            <div className="col-12">

                <div
                    className={`alert ${
                        isApproved
                            ? "alert-success"
                            : "alert-warning"
                    } mb-0`}
                >

                    <div className="d-flex">

                        <div>

                            {
                                isApproved ? (

                                    <IconCircleCheck
                                        size={28}
                                    />

                                ) : (

                                    <IconClockHour4
                                        size={28}
                                    />

                                )
                            }

                        </div>


                        <div className="ms-3">

                            <h4 className="alert-title">

                                {
                                    isApproved
                                        ? "Verification Successful"
                                        : "Verification Pending"
                                }

                            </h4>


                            <div>

                                {
                                    isApproved
                                        ? "Your verification application has been approved successfully."
                                        : "Your verification application has been submitted and is waiting for admin approval."
                                }

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {/* PERSONAL INFORMATION */}

            <div className="col-12">

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


                    <div className="card-body">

                        <div className="row">

                            <div className="col-md-6 mb-3">

                                <div className="text-secondary">

                                    First Name

                                </div>

                                <div className="fw-bold">

                                    {data?.first_name || "-"}

                                </div>

                            </div>


                            <div className="col-md-6 mb-3">

                                <div className="text-secondary">

                                    Last Name

                                </div>

                                <div className="fw-bold">

                                    {
                                        data?.last_nanme ||
                                        data?.last_name ||
                                        "-"
                                    }

                                </div>

                            </div>


                            <div className="col-md-6">

                                <div className="text-secondary">

                                    Date of Birth

                                </div>

                                <div className="fw-bold">

                                    {data?.date_of_birth || "-"}

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {/* ADDRESS INFORMATION */}

            <div className="col-12">

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


                    <div className="card-body">

                        <div className="row">

                            <div className="col-md-12 mb-3">

                                <div className="text-secondary">

                                    Address

                                </div>

                                <div className="fw-bold">

                                    {
                                        data?.verification_address ||
                                        "-"
                                    }

                                </div>

                            </div>


                            <div className="col-md-6">

                                <div className="text-secondary">

                                    Post Code

                                </div>

                                <div className="fw-bold">

                                    {data?.post_code || "-"}

                                </div>

                            </div>


                            <div className="col-md-6">

                                <div className="text-secondary">

                                    City

                                </div>

                                <div className="fw-bold">

                                    {data?.city || "-"}

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {/* VERIFICATION DOCUMENT */}

            <div className="col-12">

                <div className="card">

                    <div className="card-header">

                        <h3 className="card-title">

                            <IconFileDescription
                                size={20}
                                className="me-2"
                            />

                            Verification Document

                        </h3>

                    </div>


                    <div className="card-body">


                        {/* DOCUMENT TYPE */}

                        <div className="mb-4">

                            <div className="text-secondary">

                                Document Type

                            </div>

                            <div className="fw-bold">

                                {
                                    documentTypes[
                                        data?.doc_type
                                    ] || "-"
                                }

                            </div>

                        </div>


                        {/* DOCUMENT IMAGES */}

                        {
                            documentImages.length > 0 ? (

                                <div>

                                    <div className="text-secondary mb-3">

                                        <IconPhoto
                                            size={18}
                                            className="me-1"
                                        />

                                        Submitted Document
                                    </div>


                                    <div className="row row-cards">

                                        {
                                            documentImages.map(
                                                (
                                                    imageUrl,
                                                    index
                                                ) => (

                                                    <div
                                                        className="col-md-6"
                                                        key={index}
                                                    >

                                                        <div className="card">

                                                            <div className="card-header py-2">

                                                                <h4 className="card-title">

                                                                    {
                                                                        Number(
                                                                            data?.doc_type
                                                                        ) === 2

                                                                            ? "Passport"

                                                                            : index === 0
                                                                                ? "Front Side"
                                                                                : "Back Side"
                                                                    }

                                                                </h4>

                                                            </div>


                                                            <div className="card-body text-center">

                                                                <img

                                                                    src={imageUrl}

                                                                    alt={
                                                                        Number(
                                                                            data?.doc_type
                                                                        ) === 2

                                                                            ? "Passport"

                                                                            : index === 0
                                                                                ? "Document Front"
                                                                                : "Document Back"
                                                                    }

                                                                    className="img-fluid rounded border"

                                                                    style={{
                                                                        width: "100%",
                                                                        maxHeight: "400px",
                                                                        objectFit: "contain",
                                                                    }}

                                                                    onError={(e) => {

                                                                        console.error(
                                                                            "Image failed to load:",
                                                                            imageUrl
                                                                        );

                                                                    }}

                                                                />

                                                            </div>

                                                        </div>

                                                    </div>

                                                )
                                            )
                                        }

                                    </div>

                                </div>

                            ) : (

                                <div className="alert alert-warning mb-0">

                                    No verification document image found.

                                </div>

                            )
                        }

                    </div>

                </div>

            </div>

        </div>

    );

}