import { useEffect, useState } from "react";

import {
    IconFileDescription,
    IconUpload,
    IconArrowLeft,
    IconCheck,
    IconLoader2,
    IconPhoto,
} from "@tabler/icons-react";

import {
    useVerification,
} from "../../context/VerificationContext";


export default function DocumentVerificationForm() {

    const {

        docType,
        setDocType,

        docImage,
        setDocImage,

        loading,

        submitStep3,
        previousStep,

    } = useVerification();


    const [previewUrl, setPreviewUrl] = useState("");


    /*
     * Create image preview when a new file is selected.
     */
    useEffect(() => {

        if (!docImage) {

            setPreviewUrl("");

            return;

        }


        const url = URL.createObjectURL(docImage);

        setPreviewUrl(url);


        /*
         * Clean up object URL when component
         * is unmounted or image changes.
         */
        return () => {

            URL.revokeObjectURL(url);

        };

    }, [docImage]);


    const handleFileChange = (e) => {

        const file = e.target.files?.[0];


        if (!file) {

            setDocImage(null);

            return;

        }


        /*
         * Check image type.
         */
        const allowedTypes = [
            "image/jpeg",
            "image/jpg",
            "image/png",
            "image/webp",
        ];


        if (!allowedTypes.includes(file.type)) {

            alert(
                "Please select a JPG, JPEG, PNG or WEBP image."
            );

            e.target.value = "";

            setDocImage(null);

            return;

        }


        /*
         * Maximum 5 MB.
         */
        if (file.size > 5 * 1024 * 1024) {

            alert(
                "Image size must be less than 5 MB."
            );

            e.target.value = "";

            setDocImage(null);

            return;

        }


        setDocImage(file);

    };


    const handleSubmit = async (e) => {

        e.preventDefault();

        await submitStep3();

    };


    return (

        <div className="card">

            <div className="card-header">

                <h3 className="card-title">

                    <IconFileDescription
                        size={20}
                        className="me-2"
                    />

                    Identity Document

                </h3>

            </div>


            <form onSubmit={handleSubmit}>

                <div className="card-body">


                    {/* Document Type */}

                    <div className="mb-4">

                        <label className="form-label">

                            Document Type

                        </label>


                        <select

                            className="form-select"

                            value={docType}

                            onChange={(e) =>
                                setDocType(
                                    e.target.value
                                )
                            }

                            disabled={loading}

                        >

                            <option value="">

                                Select document type

                            </option>


                            <option value="1">

                                NID

                            </option>


                            <option value="2">

                                Passport

                            </option>


                            <option value="3">

                                Driving License

                            </option>

                        </select>

                    </div>


                    {/* Image Upload */}

                    <div className="mb-3">

                        <label className="form-label">

                            Document Image

                        </label>


                        <div
                            className="border rounded p-4 text-center"
                            style={{
                                borderStyle: "dashed",
                                backgroundColor: "#f8f9fa",
                            }}
                        >

                            <IconUpload
                                size={40}
                                className="text-primary mb-2"
                            />


                            <div className="mb-3">

                                <strong>
                                    Upload your document
                                </strong>

                                <div className="text-secondary small">

                                    JPG, JPEG, PNG or WEBP
                                    <br />
                                    Maximum 5 MB

                                </div>

                            </div>


                            <input

                                type="file"

                                className="form-control"

                                accept="image/jpeg,image/jpg,image/png,image/webp"

                                onChange={handleFileChange}

                                disabled={loading}

                            />

                        </div>

                    </div>


                    {/* Image Preview */}

                    {previewUrl && (

                        <div className="mt-4">

                            <label className="form-label fw-bold">

                                Document Preview

                            </label>


                            <div
                                className="border rounded p-2 text-center"
                                style={{
                                    backgroundColor: "#f8f9fa",
                                }}
                            >

                                <img

                                    src={previewUrl}

                                    alt="Document Preview"

                                    style={{
                                        maxWidth: "100%",
                                        maxHeight: "450px",
                                        objectFit: "contain",
                                        borderRadius: "6px",
                                    }}

                                />

                            </div>


                            <div className="mt-2 text-secondary small">

                                <IconPhoto
                                    size={16}
                                    className="me-1"
                                />

                                {docImage.name}

                            </div>

                        </div>

                    )}

                </div>


                {/* Footer */}

                <div className="card-footer d-flex justify-content-between">

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


                    <button

                        type="submit"

                        className="btn btn-primary"

                        disabled={loading}

                    >

                        {loading ? (

                            <>

                                <IconLoader2
                                    size={18}
                                    className="me-2 spinner-border spinner-border-sm"
                                />

                                Uploading...

                            </>

                        ) : (

                            <>

                                <IconCheck
                                    size={18}
                                    className="me-2"
                                />

                                Submit Verification

                            </>

                        )}

                    </button>

                </div>

            </form>

        </div>

    );

}