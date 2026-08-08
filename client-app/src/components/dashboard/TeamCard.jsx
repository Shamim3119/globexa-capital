import {
    IconUsers
} from "@tabler/icons-react";


export default function TeamCard({user}){


    return (

        <div className="row">


            <div className="col-md-6">


                <div className="card">


                    <div className="card-body">


                        <IconUsers size={30}/>


                        <h1>

                            ৳ {user?.left_balance}

                        </h1>


                        <div className="text-secondary">

                            Left Team Business

                        </div>


                    </div>


                </div>


            </div>





            <div className="col-md-6">


                <div className="card">


                    <div className="card-body">


                        <IconUsers size={30}/>


                        <h1>

                            ৳ {user?.right_balance}

                        </h1>


                        <div className="text-secondary">

                            Right Team Business

                        </div>


                    </div>


                </div>


            </div>



        </div>

    );

}