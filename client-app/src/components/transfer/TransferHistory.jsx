import {
    IconArrowsExchange,
    IconReceipt,
    IconRefresh,
} from "@tabler/icons-react";

import { useTransfer } from "../../context/TransferContext";

export default function TransferHistory() {

    const {
        transfers,
        historyLoading,
        loadTransfers,
        formatDate,
    } = useTransfer();


    return (

        <div className="card">

            <div className="card-header">

                <div className="d-flex align-items-center justify-content-between w-100">

                    <div>

                        <h3 className="card-title mb-1">

                            Transfer History

                        </h3>

                        <div className="text-secondary small">

                            Your recent fund transfers

                        </div>

                    </div>


                    <button
                        type="button"
                        className="btn btn-outline-primary"
                        onClick={loadTransfers}
                        disabled={historyLoading}
                    >

                        <IconRefresh
                            size={18}
                            className="me-1"
                        />

                        Refresh

                    </button>

                </div>

            </div>


            <div className="card-body p-0">

                {historyLoading ? (

                    <div className="text-center py-5">

                        <div
                            className="spinner-border text-primary"
                            role="status"
                        />

                        <div className="text-secondary mt-3">

                            Loading transfer history...

                        </div>

                    </div>

                ) : transfers.length === 0 ? (

                    <div className="empty">

                        <div className="empty-icon">

                            <IconReceipt
                                size={32}
                            />

                        </div>

                        <p className="empty-title">
                            No transfers found
                        </p>

                        <p className="empty-subtitle text-secondary">
                            Your transfer history will appear here.
                        </p>

                    </div>

                ) : (

                    <div className="table-responsive">

                        <table className="table table-vcenter card-table">

                            <thead>

                                <tr>

                                    <th>
                                        #
                                    </th>

                                    <th>
                                        Transfer ID
                                    </th>

                                    <th>
                                        Amount
                                    </th>

                                    <th>
                                        Date
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                {transfers.map((item, index) => (

                                    <tr key={item.id || index}>

                                        <td>

                                            <span className="text-secondary">
                                                {index + 1}
                                            </span>

                                        </td>


                                        <td>

                                            <div className="d-flex align-items-center">

                                                <span className="avatar avatar-sm bg-primary-lt me-2">

                                                    <IconArrowsExchange
                                                        size={18}
                                                    />

                                                </span>

                                                <span className="fw-bold">

                                                    #{item.id}

                                                </span>

                                            </div>

                                        </td>


                                        <td>

                                            <span className="fw-bold">

                                                $
                                                {Number(
                                                    item.amount || 0
                                                ).toFixed(2)}

                                            </span>

                                        </td>


                                        <td>

                                            <span className="text-secondary">

                                                {formatDate(
                                                    item.created_at ||
                                                    item.createdAt ||
                                                    item.date
                                                )}

                                            </span>

                                        </td>

                                    </tr>

                                ))}

                            </tbody>

                        </table>

                    </div>

                )}

            </div>

        </div>

    );

}