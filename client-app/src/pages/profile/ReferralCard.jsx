import { useToast } from "../../context/ToastContext";

import {
    IconUsers,
    IconCopy,
} from "@tabler/icons-react";

 

 

export default function ReferralCard({

    title,
    count,
    link,

}){

const {showToast}=useToast();

const copyLink = async()=>{

    await navigator.clipboard.writeText(link);

    showToast(
        "Referral link copied successfully"
    );

};

    return(

        <div className="card h-100">

            <div className="card-header">

                <h3 className="card-title">

                    {title}

                </h3>

            </div>

            <div className="card-body">

                <div className="d-flex align-items-center mb-3">

                    <span className="avatar bg-primary-lt me-3">

                        <IconUsers
                            size={22}
                            className="text-primary"
                        />

                    </span>

                    <div>

                        <div className="h2 mb-0">

                            {count}

                        </div>

                        <div className="text-secondary">

                            Team Members

                        </div>

                    </div>

                </div>


                <label className="form-label">

                    Referral Link

                </label>

                <div className="input-group">

                    <input
                        type="text"
                        className="form-control"
                        value={link}
                        readOnly
                    />

                    <button
                        className="btn btn-primary"
                        onClick={copyLink}
                    >

                        <IconCopy size={18}/>

                    </button>

                </div>

            </div>

        </div>

    );

}