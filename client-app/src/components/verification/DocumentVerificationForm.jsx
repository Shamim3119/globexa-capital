import {
    useEffect,
    useState,
} from "react";

import {
    IconFileDescription,
    IconUpload,
    IconArrowLeft,
    IconCheck,
    IconLoader2,
    IconPhoto,
    IconX,
} from "@tabler/icons-react";

import {
    useVerification,
} from "../../context/VerificationContext";


export default function DocumentVerificationForm() {

    const {

        docType,
        setDocType,

        docImages,
        setDocImages,

        loading,

        submitStep3,
        previousStep,

    } = useVerification();


    const [previewUrls, setPreviewUrls] = useState([]);


    /*
    |--------------------------------------------------------------------------
    | DOCUMENT TYPE RULE
    |--------------------------------------------------------------------------
    |
    | 1 = NID              → 2 images
    | 2 = Passport         → 1 image
    | 3 = Driving License  → 2 images
    |
    */

    const requiresBothSides =
        Number(docType) === 1 ||
        Number(docType) === 3;


    /*
    |--------------------------------------------------------------------------
    | IMAGE PREVIEWS
    |--------------------------------------------------------------------------
    */

    useEffect(() => {

        if (!docImages.length) {

            setPreviewUrls([]);

            return;

        }


        const urls = docImages.map((file) => {

            return URL.createObjectURL(file);

        });


        setPreviewUrls(urls);


        return () => {

            urls.forEach((url) => {

                URL.revokeObjectURL(url);

            });

        };

    }, [docImages]);


    /*
    |--------------------------------------------------------------------------
    | DOCUMENT TYPE CHANGE
    |--------------------------------------------------------------------------
    */

    const handleDocumentTypeChange = (e) => {

        const selectedType = e.target.value;


        setDocType(selectedType);


        /*
         * Clear previously selected images
         * when changing document type.
         */

        setDocImages([]);

    };


    /*
    |--------------------------------------------------------------------------
    | FILE CHANGE
    |--------------------------------------------------------------------------
    */

    const handleFileChange = (e) => {

        const selectedFiles = Array.from(
            e.target.files || []
        );


        if (!selectedFiles.length) {

            setDocImages([]);

            return;

        }


        /*
         * Passport can have only one image.
         */

        if (
            Number(docType) === 2 &&
            selectedFiles.length > 1
        ) {

            alert(
                "Passport requires only one image."
            );

            e.target.value = "";

            setDocImages([]);

            return;

        }


        /*
         * NID and Driving License
         * require Front + Back.
         */

        if (
            requiresBothSides &&
            selectedFiles.length > 2
        ) {

            alert(
                "Please upload only Front and Back images."
            );

            e.target.value = "";

            setDocImages([]);

            return;

        }


        const allowedTypes = [

            "image/jpeg",
            "image/png",
            "image/webp",

        ];


        for (const file of selectedFiles) {

            if (
                !allowedTypes.includes(
                    file.type
                )
            ) {

                alert(
                    "Please select only JPG, JPEG, PNG or WEBP images."
                );

                e.target.value = "";

                setDocImages([]);

                return;

            }


            /*
             * Maximum 5 MB per image.
             */

            if (
                file.size >
                5 * 1024 * 1024
            ) {

                alert(
                    "Each image must be less than 5 MB."
                );

                e.target.value = "";

                setDocImages([]);

                return;

            }

        }


        /*
         * Store all selected images.
         */

        setDocImages(selectedFiles);

    };


    /*
    |--------------------------------------------------------------------------
    | REMOVE IMAGE
    |--------------------------------------------------------------------------
    */

    const removeImage = (index) => {

        setDocImages((currentImages) =>
            currentImages.filter(
                (_, imageIndex) =>
                    imageIndex !== index
            )
        );

    };


    /*
    |--------------------------------------------------------------------------
    | SUBMIT
    |--------------------------------------------------------------------------
    */

    const handleSubmit = async (e) => {

        e.preventDefault();

        await submitStep3();

    };


    /*
    |--------------------------------------------------------------------------
    | LABELS
    |--------------------------------------------------------------------------
    */

    const getImageTitle = (index) => {

        if (
            Number(docType) === 2
        ) {

            return "Passport Image";

        }


        return index === 0
            ? "Front Side"
            : "Back Side";

    };


    const getUploadText = () => {

        if (
            Number(docType) === 1
        ) {

            return "Upload NID Front and Back sides";

        }


        if (
            Number(docType) === 3
        ) {

            return "Upload Driving License Front and Back sides";

        }


        if (
            Number(docType) === 2
        ) {

            return "Upload Passport image";

        }


        return "Select document type first";

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


            <form
                onSubmit={handleSubmit}
            >

                <div className="card-body">


                    {/* DOCUMENT TYPE */}

                    <div className="mb-4">

                        <label className="form-label">

                            Document Type

                        </label>


                        <select

                            className="form-select"

                            value={docType}

                            onChange={
                                handleDocumentTypeChange
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


                    {/* DOCUMENT REQUIREMENT */}

                    {docType && (

                        <div
                            className="alert alert-info"
                        >

                            {

                                requiresBothSides

                                    ? (

                                        <>
                                            <strong>
                                                Two images required:
                                            </strong>

                                            <br />

                                            1. Front Side

                                            <br />

                                            2. Back Side
                                        </>

                                    )

                                    : (

                                        <>
                                            <strong>
                                                One image required:
                                            </strong>

                                            <br />

                                            Upload the Passport image.
                                        </>

                                    )

                            }

                        </div>

                    )}


                    {/* FILE UPLOAD */}

                    {docType && (

                        <div className="mb-4">

                            <label className="form-label">

                                Document Image

                            </label>


                            <div

                                className="border rounded p-4 text-center"

                                style={{

                                    borderStyle:
                                        "dashed",

                                    backgroundColor:
                                        "#f8f9fa",

                                }}

                            >

                                <IconUpload

                                    size={40}

                                    className="text-primary mb-2"

                                />


                                <div className="mb-3">

                                    <strong>

                                        {
                                            getUploadText()
                                        }

                                    </strong>


                                    <div
                                        className="text-secondary small"
                                    >

                                        JPG, JPEG, PNG or WEBP

                                        <br />

                                        Maximum 5 MB per image

                                    </div>

                                </div>


                                <input

                                    type="file"

                                    className="form-control"

                                    accept="
                                        image/jpeg,
                                        image/png,
                                        image/webp
                                    "

                                    multiple={
                                        requiresBothSides
                                    }

                                    onChange={
                                        handleFileChange
                                    }

                                    disabled={
                                        loading
                                    }

                                />

                            </div>

                        </div>

                    )}


                    {/* IMAGE PREVIEWS */}

                    {

                        previewUrls.length > 0 && (

                            <div className="mt-4">

                                <label
                                    className="form-label fw-bold"
                                >

                                    Document Preview

                                </label>


                                <div className="row row-cards">

                                    {

                                        previewUrls.map(
                                            (
                                                previewUrl,
                                                index
                                            ) => (

                                                <div

                                                    className="col-md-6"

                                                    key={
                                                        previewUrl
                                                    }

                                                >

                                                    <div
                                                        className="card"
                                                    >

                                                        <div
                                                            className="card-header d-flex justify-content-between"
                                                        >

                                                            <strong>

                                                                {

                                                                    getImageTitle(
                                                                        index
                                                                    )

                                                                }

                                                            </strong>


                                                            <button

                                                                type="button"

                                                                className="btn btn-sm btn-outline-danger"

                                                                onClick={() =>
                                                                    removeImage(
                                                                        index
                                                                    )
                                                                }

                                                                disabled={
                                                                    loading
                                                                }

                                                            >

                                                                <IconX
                                                                    size={16}
                                                                />

                                                            </button>

                                                        </div>


                                                        <div
                                                            className="card-body text-center"
                                                        >

                                                            <img

                                                                src={
                                                                    previewUrl
                                                                }

                                                                alt={
                                                                    getImageTitle(
                                                                        index
                                                                    )
                                                                }

                                                                className="img-fluid rounded"

                                                                style={{

                                                                    maxHeight:
                                                                        "300px",

                                                                    objectFit:
                                                                        "contain",

                                                                }}

                                                            />


                                                            <div
                                                                className="mt-2 text-secondary small"
                                                            >

                                                                <IconPhoto
                                                                    size={16}
                                                                    className="me-1"
                                                                />

                                                                {

                                                                    docImages[
                                                                        index
                                                                    ]?.name

                                                                }

                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>

                                            )
                                        )

                                    }

                                </div>

                            </div>

                        )

                    }

                </div>


                {/* FOOTER */}

                <div
                    className="card-footer d-flex justify-content-between"
                >

                    <button

                        type="button"

                        className="btn btn-outline-secondary"

                        onClick={
                            previousStep
                        }

                        disabled={
                            loading
                        }

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

                        disabled={

                            loading ||

                            !docType ||

                            docImages.length === 0 ||

                            (
                                requiresBothSides &&
                                docImages.length < 2
                            )

                        }

                    >

                        {

                            loading

                                ? (

                                    <>

                                        <IconLoader2
                                            size={18}
                                            className="me-2 spinner-border spinner-border-sm"
                                        />

                                        Uploading...

                                    </>

                                )

                                : (

                                    <>

                                        <IconCheck
                                            size={18}
                                            className="me-2"
                                        />

                                        Submit Verification

                                    </>

                                )

                        }

                    </button>

                </div>

            </form>

        </div>

    );

}