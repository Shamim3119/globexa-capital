import {
    IconReceipt,
} from "@tabler/icons-react";

import { useIncome } from "../../context/IncomeContext";


export default function IncomeHistory() {

    const {
        rows,
        total,
        reportType,
        incomeType,
        loading,
        formatDisplayDate,
    } = useIncome();


    const displayType = reportType
        ? reportType.replace(" Income", "")
        : incomeType
            ? incomeType.replace(" Income", "")
            : "-";


    return (

        <div className="card mt-3">

            <div className="card-header">

                <div className="d-flex align-items-center">

                    <span className="avatar avatar-sm me-2">
                        <IconReceipt size={20} />
                    </span>

                    <div>

                        <h3 className="card-title mb-0">
                            {incomeType
                                ? incomeType
                                : "Income History"}
                        </h3>

                        <div className="text-secondary small">
                            Income records
                        </div>

                    </div>

                </div>

            </div>


            <div className="card-body p-0">

                {loading ? (

                    <div className="text-center py-5">

                        <div
                            className="spinner-border text-primary"
                            role="status"
                        />

                        <div className="text-secondary mt-2">
                            Loading income records...
                        </div>

                    </div>

                ) : rows.length === 0 ? (

                    <div className="empty">

                        <div className="empty-icon">
                            <IconReceipt size={40} />
                        </div>

                        <p className="empty-title">
                            No income records found
                        </p>

                        <p className="empty-subtitle text-secondary">
                            Select an income type and date range,
                            then click Search.
                        </p>

                    </div>

                ) : (

                    <div className="table-responsive">

                        <table className="table table-vcenter card-table">

                            <thead>

                                <tr>

                                    <th className="text-center">
                                        SL
                                    </th>

                                    <th>
                                        Type
                                    </th>

                                    <th>
                                        Date
                                    </th>

                                    <th className="text-end">
                                        Amount
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                {rows.map((item, index) => (

                                    <tr key={item.id ?? index}>

                                        <td className="text-center">
                                            {index + 1}
                                        </td>


                                        <td>

                                            <span className="badge bg-blue-lt">

                                                {displayType}

                                            </span>

                                        </td>


                                        <td>

                                            {formatDisplayDate(
                                                item.created_at
                                            )}

                                        </td>


                                        <td className="text-end fw-bold">

                                            {Number(
                                                item.amount || 0
                                            ).toFixed(5)}

                                        </td>

                                    </tr>

                                ))}

                            </tbody>


                            <tfoot>

                                <tr>

                                    <th
                                        colSpan="3"
                                        className="text-end"
                                    >
                                        Total
                                    </th>

                                    <th className="text-end">

                                        {Number(
                                            total || 0
                                        ).toFixed(2)}

                                    </th>

                                </tr>

                            </tfoot>

                        </table>

                    </div>

                )}

            </div>

        </div>

    );

}