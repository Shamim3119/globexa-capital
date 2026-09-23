import {
    IconCrown,
} from "@tabler/icons-react";

export default function WelcomeCard({ user }) {

    const firstLetter =
        user?.name?.charAt(0)?.toUpperCase() || "U";


    const avatar = user?.photo
        ? `${import.meta.env.VITE_API_URL.replace(
              "/api",
              ""
          )}/storage/${user.photo}`
        : null;


    return (

        <div className="welcome-card">

            <div className="welcome-card-body">

                <div className="row align-items-center g-3">

                    {/* Left */}

                    <div className="col">

                        <div className="welcome-label">
                            Welcome back
                        </div>

                        <h2 className="welcome-title">
                            {user?.name || "User"}
                        </h2>


                        <div className="welcome-info">

                            <span className="welcome-rank">

                                Rank:
                                {" "}

                                <strong>
                                    {user?.designation || "Member"}
                                </strong>

                            </span>


                            <span className="welcome-divider">
                                •
                            </span>


                            <span className="welcome-salary">

                                <IconCrown size={17} />

                                Salary:
                                {" "}

                                <strong>
                                    $ {user?.salary_amount || "0.00"}
                                </strong>

                            </span>

                        </div>

                    </div>


                    {/* Right */}

                    <div className="col-auto">

                        <div className="welcome-avatar">

                            {avatar ? (

                                <img
                                    src={avatar}
                                    alt={
                                        user?.name ||
                                        "User"
                                    }
                                />

                            ) : (

                                firstLetter

                            )}

                        </div>

                    </div>

                </div>

            </div>

        </div>

    );

}