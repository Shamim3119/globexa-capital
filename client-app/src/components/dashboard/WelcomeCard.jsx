import {
    IconCrown
} from "@tabler/icons-react";


export default function WelcomeCard({user}){


    return (

        <div className="card bg-primary text-white">

            <div className="card-body">


                <div className="row align-items-center">


                    <div className="col">


                        <h2 className="mb-1">

                            Welcome,
                            {" "}
                            {user?.name}

                        </h2>


                        <div>

                            Rank:
                            {" "}
                            {user?.designation}

                        </div>


                        <div className="mt-2">

                            <IconCrown size={18}/>

                            Salary:
                            {" "}
                            ৳ {user?.salary_amount}

                        </div>


                    </div>


                    <div className="col-auto">


                        <span className="avatar avatar-xl">

                            {
                                user?.name
                                ?.charAt(0)
                            }

                        </span>


                    </div>


                </div>


            </div>

        </div>

    );

}