import SalesForm from "../../components/sales/SalesForm";
import SalesHistory from "../../components/sales/SalesHistory";


export default function Sales() {

    return (

        <div className="page">

            <div className="container-xl">


                {/* Page Header */}

                <div className="page-header d-print-none">

                    <div className="row align-items-center">

                        <div className="col">

                            <div className="page-pretitle">

                                Reports

                            </div>


                            <h2 className="page-title">

                                Sales Report

                            </h2>

                        </div>

                    </div>

                </div>



                {/* Search Form */}

                <SalesForm />



                {/* Report Result */}

                <SalesHistory />


            </div>

        </div>

    );

}