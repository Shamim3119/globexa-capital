import { useEffect, useState } from "react";

import {
    IconFileDescription,
    IconDownload,
    IconExternalLink,
    IconAlertCircle,
} from "@tabler/icons-react";

import api from "../../api/api";

export default function CompanyDocuments() {

    const [pdfUrl, setPdfUrl] = useState("");
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState("");

    useEffect(() => {

        const loadDocument = async () => {

            try {

                setLoading(true);
                setError("");

                const res = await api.get("/business-doc");

                console.log("Business Document Response:", res.data);

                if (
                    res.data?.status &&
                    res.data?.data?.company_doc
                ) {

                    const url = res.data.data.company_doc;

                    console.log("PDF URL:", url);

                    setPdfUrl(url);

                } else {

                    setPdfUrl("");

                    setError("Company document is not available.");

                }

            } catch (err) {

                console.error("Company Document Error:", err);

                setError(
                    err?.response?.data?.message ||
                    "Failed to load company document."
                );

            } finally {

                setLoading(false);

            }

        };

        loadDocument();

    }, []);


    /*
     * Loading
     */

    if (loading) {

        return (

            <div className="page">

                <div className="container-xl">

                    <div className="page-header">

                        <h2 className="page-title">
                            Company Documents
                        </h2>

                    </div>

                    <div className="card">

                        <div className="card-body text-center py-5">

                            <div
                                className="spinner-border text-primary mb-3"
                                role="status"
                            />

                            <div className="text-secondary">
                                Loading company document...
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        );

    }


    /*
     * Error / no PDF
     */

    if (error || !pdfUrl) {

        return (

         
            <div className="page">

                <div className="container-xl">

                    <div className="page-header">

                        <div>

                            <div className="page-pretitle">
                                Company
                            </div>

                            <h2 className="page-title">
                                Company Documents
                           
                            </h2>

                        </div>

                    </div>


                    <div className="alert alert-danger d-flex align-items-center">

                        <IconAlertCircle
                            size={20}
                            className="me-2"
                        />

                        {error || "No company document available."}

                    </div>

                </div>

            </div>

        );

    }


    /*
     * Google PDF Viewer
     *
     * Same concept as your React Native WebView.
     */

    const viewerUrl =
        `https://docs.google.com/gview?embedded=1&url=${encodeURIComponent(pdfUrl)}`;


    return (

            <>

                {/* Page Header */}

                <div className="page-header d-print-none">

                    <div className="row align-items-center">

                        <div className="col">

                            <div className="d-flex align-items-center gap-2">

                                <span className="text-secondary">
                                    Company
                                </span>

                                <span className="text-secondary">
                                    /
                                </span>

                                <h2 className="page-title mb-0">
                                    Company Documents
                                </h2>

                            </div>

                        </div>

                        <div className="col-auto">

                            <div className="btn-list gap-2">

                                <a
                                    href={pdfUrl}
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    className="btn btn-outline-primary"
                                >
                                    <IconExternalLink
                                        size={18}
                                        className="me-2"
                                    />

                                    View PDF
                                </a>

                                <a
                                    href={pdfUrl}
                                    download
                                    className="btn btn-primary"
                                >
                                    <IconDownload
                                        size={18}
                                        className="me-2"
                                    />

                                    Download
                                </a>

                            </div>

                        </div>

                    </div>

                </div>

                {/* Gap between buttons and PDF */}

                <div className="card mt-3">

                    <div className="card-header">

                        <div className="d-flex align-items-center">

                            <IconFileDescription
                                size={22}
                                className="me-2 text-primary"
                            />

                            <div>

                                <h3 className="card-title mb-0">
                                    Company Document
                                </h3>

                                <div className="text-secondary small">
                                    Official company document
                                </div>

                            </div>

                        </div>

                    </div>


                    {/* PDF Viewer */}

                    <div
                        className="card-body p-0"
                        style={{
                            height: "calc(100vh - 280px)",
                            minHeight: "600px",
                        }}
                    >

                        <iframe
                            src={pdfUrl}
                            title="Company Document"
                            width="100%"
                            height="100%"
                            style={{
                                border: "none",
                                display: "block",
                            }}
                        />

                    </div>

                </div>

            </>
 

    );

}