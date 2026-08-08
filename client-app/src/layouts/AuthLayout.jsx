import logo from "../assets/images/logo.png";

export default function AuthLayout({ children }) {
    return (
        <div className="auth-wrapper">

            {/* Left Side */}
            <div className="auth-left">

                <div className="brand">

                    <img
                        src={logo}
                        alt="Globexa Capital"
                        className="brand-logo"
                    />

                    <h1>Globexa Capital</h1>

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

                <div className="login-card">

                    {children}

                </div>

            </div>

        </div>
    );
}