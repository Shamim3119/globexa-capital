import logo from "../assets/images/logo.png";
import bgImage from "../assets/images/background-login.jpeg"; // 1. Import image

export default function AuthLayout({ children }) {
    return (
        <div className="auth-wrapper">

            {/* Left Side */}
            <div className="auth-left">

                <div className="brand">

                    <img
                        src={logo}
                        alt="Globexa Capital Ltd."
                        className="brand-logo"
                          style={{ width: "200px", height: "auto" }}
                    />

                    <h1>Globexa Capital Ltd.</h1>

                    <p>
                        Secure Investment Platform
                    </p>

                </div>

                <div className="features">

                    <div className="feature">
                        ✓ Secure Investment
                    </div>

                    <div className="feature">
                        ✓ Instant Deposits
                    </div>

                    <div className="feature">
                        ✓ Global Opportunities
                    </div>

                    <div className="feature">
                        ✓ 24/7 Client Support
                    </div>

                </div>

            </div>

            {/* Right Side */}
            <div className="auth-right">

                <div 
                    className="login-card"
                    /*
                    style={{
                        backgroundImage: `url(${bgImage})`,
                        backgroundSize: "cover",
                        backgroundPosition: "center",
                        backgroundRepeat: "no-repeat"
                    }}
                        */
                >

                    {children}

                </div>

            </div>

        </div>
    );
}