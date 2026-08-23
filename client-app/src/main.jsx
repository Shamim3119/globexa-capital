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

import {
    DepositProvider
} from "./context/DepositContext";

import { 
    InvestmentProvider 
} from "./context/InvestmentContext";

import { 
    WithdrawProvider 
} from "./context/WithdrawContext.jsx";

import { TeamProvider } from "./context/TeamContext";
import { TransferProvider } from "./context/TransferContext";
import { P2PProvider } from "./context/P2PContext";
import { RefundProvider } from "./context/RefundContext";
import { AccountProvider } from "./context/AccountContext";
import { IncomeProvider } from "./context/IncomeContext";
import { SalesProvider } from "./context/SalesContext";
import {VerificationProvider} from "./context/VerificationContext";
 
import { SidebarProvider } from "./context/SidebarContext.jsx";


createRoot(document.getElementById("root")).render(
    <StrictMode>
        <ThemeProvider>
            <AuthProvider>
                <SidebarProvider>
                    <ToastProvider>
                        <DashboardProvider>
                            <DepositProvider>
                                <InvestmentProvider>
                                    <WithdrawProvider>
                                        <TeamProvider>
                                            <TransferProvider>
                                                 <P2PProvider>
                                                    <RefundProvider>
                                                        <AccountProvider>
                                                            <IncomeProvider>
                                                                <SalesProvider>
                                                                    <VerificationProvider>
                                                                        <App />
                                                                    </VerificationProvider>
                                                                </SalesProvider>
                                                            </IncomeProvider>
                                                        </AccountProvider>
                                                    </RefundProvider>
                                                 </P2PProvider>
                                            </TransferProvider>
                                        </TeamProvider>
                                    </WithdrawProvider>
                                </InvestmentProvider>
                            </DepositProvider>
                        </DashboardProvider>
                    </ToastProvider>
                </SidebarProvider>
            </AuthProvider>
        </ThemeProvider>
    </StrictMode>
);