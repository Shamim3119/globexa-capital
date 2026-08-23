import {
    IconSearch,
    IconCalendar,
    IconUser,
    IconFilter,
} from "@tabler/icons-react";

import { useSales } from "../../context/SalesContext";
import { useToast } from "../../context/ToastContext";


export default function SalesForm() {

    const {

        startDate,
        setStartDate,

        endDate,
        setEndDate,

        inactive,
        setInactive,

        clientId,
        setClientId,

        statusOptions,

        loading,
        searchSales,

    } = useSales();


    const { showToast } = useToast();


    const handleSubmit = async (e) => {

        e.preventDefault();


        if (startDate > endDate) {

            showToast(
                "Start date cannot be greater than end date.",
                "error"
            );

            return;

        }


        const response = await searchSales();


        if (!response.success) {

            showToast(
                response.message,
                "error"
            );

        }

    };


    return (

        <div className="card mb-4">

            <div className="card-body">

                <form onSubmit={handleSubmit}>

                    <div className="row g-3">


                        {/* Start Date */}

                        <div className="col-12 col-md-6 col-lg-3">

                            <label className="form-label">

                                <IconCalendar
                                    size={16}
                                    className="me-1"
                                />

                                Start Date

                            </label>


                            <input
                                type="date"
                                className="form-control"
                                value={startDate}
                                onChange={(e) =>
                                    setStartDate(e.target.value)
                                }
                            />

                        </div>



                        {/* End Date */}

                        <div className="col-12 col-md-6 col-lg-3">

                            <label className="form-label">

                                <IconCalendar
                                    size={16}
                                    className="me-1"
                                />

                                End Date

                            </label>


                            <input
                                type="date"
                                className="form-control"
                                value={endDate}
                                onChange={(e) =>
                                    setEndDate(e.target.value)
                                }
                            />

                        </div>



                        {/* Status */}

                        <div className="col-12 col-md-6 col-lg-2">

                            <label className="form-label">

                                <IconFilter
                                    size={16}
                                    className="me-1"
                                />

                                Status

                            </label>


                            <select
                                className="form-select"
                                value={inactive}
                                onChange={(e) =>
                                    setInactive(e.target.value)
                                }
                            >

                                {
                                    statusOptions.map((option) => (

                                        <option
                                            key={option.value}
                                            value={option.value}
                                        >
                                            {option.label}
                                        </option>

                                    ))
                                }

                            </select>

                        </div>



                        {/* Client ID */}

                        <div className="col-12 col-md-6 col-lg-2">

                            <label className="form-label">

                                <IconUser
                                    size={16}
                                    className="me-1"
                                />

                                Client ID

                            </label>


                            <input
                                type="number"
                                className="form-control"
                                placeholder="Optional"
                                value={clientId}
                                onChange={(e) =>
                                    setClientId(e.target.value)
                                }
                            />

                        </div>



                        {/* Search */}

                        <div className="col-12 col-lg-2 d-flex align-items-end">

                            <button
                                type="submit"
                                className="btn btn-primary w-100"
                                disabled={loading}
                            >

                                {
                                    loading ? (

                                        <>

                                            <span
                                                className="
                                                    spinner-border
                                                    spinner-border-sm
                                                    me-2
                                                "
                                            />

                                            Loading...

                                        </>

                                    ) : (

                                        <>

                                            <IconSearch
                                                size={18}
                                                className="me-2"
                                            />

                                            Search

                                        </>

                                    )
                                }

                            </button>

                        </div>


                    </div>

                </form>

            </div>

        </div>

    );

}