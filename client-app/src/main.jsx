import { StrictMode } from 'react'
import { createRoot } from 'react-dom/client'

import "@tabler/core/dist/css/tabler.min.css";
import "@tabler/core/dist/css/tabler-flags.min.css";
import "@tabler/core/dist/css/tabler-payments.min.css";
import "@tabler/core/dist/js/tabler.min.js";

import './index.css'
import './assets/styles/custom.css'

import App from './App.jsx'
import { AuthProvider } from './context/AuthContext.jsx'
import { ThemeProvider } from './context/ThemeContext.jsx'

import {
    ToastProvider
} from "./context/ToastContext";

import {
    DashboardProvider
} from "./context/DashboardContext";

import { SidebarProvider } from "./context/SidebarContext";
 

createRoot(document.getElementById('root')).render(

<StrictMode>

    <ThemeProvider>

        <AuthProvider>

            <SidebarProvider>

                <DashboardProvider>

                    <ToastProvider>

                        <App />

                    </ToastProvider>

                </DashboardProvider>

            </SidebarProvider>

        </AuthProvider>

    </ThemeProvider>

</StrictMode>

)