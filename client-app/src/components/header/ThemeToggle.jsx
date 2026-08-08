import {
    IconMoon,
    IconSun,
} from "@tabler/icons-react";

import { useTheme } from "../../context/ThemeContext";

export default function ThemeToggle() {

    const { theme, toggleTheme } = useTheme();

    return (

        <div className="nav-item">

            <button
                type="button"
                className="btn btn-icon"
                title="Toggle Theme"
                onClick={toggleTheme}
            >

                {
                    theme === "dark"
                    ?
                    <IconSun
                        size={20}
                        className="icon"
                    />
                    :
                    <IconMoon
                        size={20}
                        className="icon"
                    />
                }

            </button>

        </div>

    );

}