import {
    IconRefresh,
} from "@tabler/icons-react";

import { useRefund } from "../../context/RefundContext";

import RefundList from "../../components/refund/RefundList";
import RefundDetails from "../../components/refund/RefundDetails";


export default function Refund() {

    const {
        refundData,
    } = useRefund();


    return (

        <>

            {/* Page Header */}

            <div className="page-header d-print-none">

                <div className="row align-items-center">

                    <div className="col">

                        <div className="d-flex align-items-center gap-2">

                            <span className="text-secondary">
                                Transactions
                            </span>

                            <span className="text-secondary">
                                /
                            </span>

                            <h2 className="page-title mb-0">
                                Refund
                            </h2>

                        </div>

                    </div>

                </div>

            </div>


            {/* Content */}

            {refundData
                ? <RefundDetails />
                : <RefundList />
            }

        </>

    );

}