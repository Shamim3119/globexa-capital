export default function BalanceCard({
    title,
    value,
    icon:Icon,
    color="primary"
}){


    return (

        <div className="col-md-4">


            <div className="card">


                <div className="card-body">


                    <div className="d-flex">


                        <span
                        className={`avatar bg-${color}-lt me-3`}
                        >

                            <Icon size={25}/>

                        </span>



                        <div>


                            <div className="text-secondary">

                                {title}

                            </div>


                            <h2 className="mb-0">

                                ৳ {value}

                            </h2>


                        </div>


                    </div>


                </div>


            </div>


        </div>

    );

}