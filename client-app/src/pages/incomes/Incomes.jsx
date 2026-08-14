import IncomeForm from "../../components/income/IncomeForm";
import IncomeHistory from "../../components/income/IncomeHistory";

export default function Incomes() {

    return (

            <>

            {/* Page Header */}

            <div className="page-header d-print-none">

                <div className="row align-items-center">

                    <div className="col">

                        <div className="d-flex align-items-center gap-2">

                            <span className="text-secondary">
                                Report
                            </span>

                            <span className="text-secondary">
                                /
                            </span>

                            <h2 className="page-title mb-0">
                                Incomes
                            </h2>

                        </div>

                    </div>

                </div>

            </div>


                {/* Income Search Form */}
                <IncomeForm />


                {/* Income History */}
                <IncomeHistory />

            </>

    );

}