import {
    IconSearch,
    IconCalendar,
    IconFilter,
} from "@tabler/icons-react";

import { useIncome } from "../../context/IncomeContext";

export default function IncomeForm() {

    const {
        incomeType,
        setIncomeType,

        fromDate,
        setFromDate,

        toDate,
        setToDate,

        incomeTypes,

        searchIncome,

        loading,
        error,
    } = useIncome();


    const handleSubmit = async (e) => {

        e.preventDefault();

        await searchIncome();

    };


    return (

        <div className="card shadow-sm">

            {/* Header */}

            <div className="card-header">

                <div className="d-flex align-items-center">

                    <span
                        className="avatar avatar-sm bg-primary-lt me-3"
                    >
                        <IconFilter
                            size={20}
                            className="text-primary"
                        />
                    </span>

                    <div>

                        <h3 className="card-title mb-1">
                            Income Search
                        </h3>

                        <div className="text-secondary small">
                            Filter your income history by type and date
                        </div>

                    </div>

                </div>

            </div>


            {/* Body */}

            <div className="card-body">

                {error && (

                    <div
                        className="alert alert-danger mb-4"
                        role="alert"
                    >
                        {error}
                    </div>

                )}


                <form onSubmit={handleSubmit}>

                    <div className="row g-3">


                        {/* Income Type */}

                        <div className="col-12 col-lg-4">

                            <label
                                className="form-label"
                                htmlFor="incomeType"
                            >
                                Income Type
                            </label>

                            <select
                                id="incomeType"
                                className="form-select"
                                value={incomeType}
                                onChange={(e) =>
                                    setIncomeType(
                                        e.target.value
                                    )
                                }
                            >

                                {incomeTypes.map((type) => (

                                    <option
                                        key={type.value}
                                        value={type.value}
                                    >
                                        {type.label}
                                    </option>

                                ))}

                            </select>

                        </div>


                        {/* From Date */}

                        <div className="col-12 col-md-6 col-lg-3">

                            <label
                                className="form-label"
                                htmlFor="fromDate"
                            >
                                From Date
                            </label>

                            <div className="input-icon">

                                <span className="input-icon-addon">

                                    <IconCalendar
                                        size={18}
                                    />

                                </span>

                                <input
                                    id="fromDate"
                                    type="date"
                                    className="form-control"
                                    value={fromDate}
                                    onChange={(e) =>
                                        setFromDate(
                                            e.target.value
                                        )
                                    }
                                />

                            </div>

                        </div>


                        {/* To Date */}

                        <div className="col-12 col-md-6 col-lg-3">

                            <label
                                className="form-label"
                                htmlFor="toDate"
                            >
                                To Date
                            </label>

                            <div className="input-icon">

                                <span className="input-icon-addon">

                                    <IconCalendar
                                        size={18}
                                    />

                                </span>

                                <input
                                    id="toDate"
                                    type="date"
                                    className="form-control"
                                    value={toDate}
                                    onChange={(e) =>
                                        setToDate(
                                            e.target.value
                                        )
                                    }
                                />

                            </div>

                        </div>


                        {/* Search Button */}

                        <div className="col-12 col-lg-2 d-flex align-items-end">

                            <button
                                type="submit"
                                className="btn btn-primary w-100"
                                disabled={loading}
                            >

                                {loading ? (

                                    <>
                                        <span
                                            className="spinner-border spinner-border-sm me-2"
                                            role="status"
                                            aria-hidden="true"
                                        />

                                        Searching...
                                    </>

                                ) : (

                                    <>
                                        <IconSearch
                                            size={18}
                                            className="me-2"
                                        />

                                        Search
                                    </>

                                )}

                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </div>

    );

}