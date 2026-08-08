import {
    Link
} from "react-router-dom";


export default function QuickActions(){


    return (

        <div className="card">


            <div className="card-header">

                Quick Actions

            </div>


            <div className="card-body">


                <div className="row">


                    <div className="col">


                        <Link
                        to="/deposit"
                        className="btn btn-primary w-100"
                        >

                            Deposit

                        </Link>


                    </div>



                    <div className="col">


                        <Link
                        to="/withdraw"
                        className="btn btn-success w-100"
                        >

                            Withdraw

                        </Link>


                    </div>



                    <div className="col">


                        <Link
                        to="/investment"
                        className="btn btn-warning w-100"
                        >

                            Investment

                        </Link>


                    </div>


                </div>


            </div>


        </div>

    );

}