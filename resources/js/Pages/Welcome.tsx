import React, { useState } from "react";
import { Head, usePage } from "@inertiajs/react";
import { useRoute } from 'ziggy-js';
import NavbarComponent from "@/Components/Navbar";

export default function WelcomePage() {
    // const { auth } : any = usePage().props
    const [count, setCount] = useState(5);

    // setTimeout(() => {
    //     setCount(count - 1);
    //     if (count <= 0) {
    //         window.open("http://localhost:8000", "_self");
    //         window.close();
    //     }
    // }, 1000);

    const route = useRoute();
    return (
        <main className="min-h-screen w-full flex flex-col bg-slate-900">
            <Head title="Welcome" />
            <NavbarComponent />
            <h1 className="text-white">
                {/* Welcome {auth && auth.user.name} */}
            </h1>
            <a href={route('welcome')}>href</a>

            {/* <div className="text-white">
                {count}
            </div> */}
        </main>
    );
}