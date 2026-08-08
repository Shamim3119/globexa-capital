import {
    createContext,
    useContext,
    useEffect,
    useState
} from "react";

const SidebarContext = createContext();

export function SidebarProvider({children}){


const [collapsed,setCollapsed] = useState(()=>{

    if(window.innerWidth < 992){
        return false;
    }

    return localStorage.getItem("sidebar") === "collapsed";

});


const [mobileOpen,setMobileOpen] = useState(false);


// ADD THIS

useEffect(()=>{

    const handleResize = ()=>{

        if(window.innerWidth < 992){

            setCollapsed(false);

        }

    };


    window.addEventListener(
        "resize",
        handleResize
    );


    return ()=>{

        window.removeEventListener(
            "resize",
            handleResize
        );

    };


},[]);



const toggleSidebar = ()=>{

    setCollapsed(prev=>!prev);

};



const toggleMobileSidebar = ()=>{

    setMobileOpen(prev=>!prev);

};



const closeMobileSidebar = ()=>{

    setMobileOpen(false);

};



useEffect(()=>{

    localStorage.setItem(
        "sidebar",
        collapsed ? "collapsed" : "expanded"
    );

},[collapsed]);



return (

    <SidebarContext.Provider

        value={{
            collapsed,
            toggleSidebar,

            mobileOpen,
            toggleMobileSidebar,
            closeMobileSidebar
        }}

    >

        {children}

    </SidebarContext.Provider>

);

}



export function useSidebar(){

    return useContext(SidebarContext);

}