import React, { useEffect, useState, useRef } from "react";
import { Head, usePage } from "@inertiajs/react";
import { useRoute } from 'ziggy-js';
import NavbarComponent from "@/Components/Navbar";
import {Html5QrcodeScanner, Html5QrcodeScanType} from "html5-qrcode";

export default function ScannerPage() {
    // const { auth } : any = usePage().props

    const route = useRoute();
    const [scannedCode, setScannedCode] = useState<string | null>(null);
    const [showPopup, setShowPopup] = useState(false);
    const scannerRef = useRef<Html5QrcodeScanner | null>(null);
    const [isScanning, setIsScanning] = useState(false);

    useEffect(() => {
        if (isScanning) {
            const html5QrcodeScanner = new Html5QrcodeScanner(
                "reader",
                { 
                    fps: 40, 
                    qrbox: 250,
                    supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA],
                    videoConstraints: {
                        facingMode: "environment" // Use back camera
                    }
                },
                false
            );
            scannerRef.current = html5QrcodeScanner;
            html5QrcodeScanner.render(onScanSuccess, onScanError);
        }

        return () => {
            // Cleanup scanner unmount
            if (scannerRef.current) {
                scannerRef.current.clear().catch(console.error);
            }
        };
    }, [isScanning]);

    const onScanSuccess = async (decodedText: string, decodedResult: any) => {
        // debuggin purposes
        // console.log(`Code matched = ${decodedText}`, decodedResult);
        
        // Stop the scanner
        if (scannerRef.current) {
            await scannerRef.current.clear();
            setIsScanning(false);
        }
        
        // Set the scanned code and show popup
        setScannedCode(decodedText);
        setShowPopup(true);

        // TODO: API call here
        // try {
        //     const response = await fetch(`/api/items/${decodedText}`);
        //     const data = await response.json();
        // } catch (error) {
        //     console.error('Error fetching item:', error);
        // }
    };

    const onScanError = (error: any) => {
        // debugging purposes
        // console.error(`Error = ${error}`);
    };

    const handleStartScanner = () => {
        setIsScanning(true);
    };

    const handleStopScanner = async () => {
        if (scannerRef.current) {
            await scannerRef.current.clear();
        }
        setIsScanning(false);
    };

    const handleScanAgain = () => {
        setShowPopup(false);
        setScannedCode(null);
        setIsScanning(true);
    };

    const handleClosePopup = () => {
        setShowPopup(false);
    };

    return (
        <main className="min-h-screen w-full flex flex-col justify-center items-center p-4">
            <Head title="Scanner" />
            {/* <NavbarComponent /> */}
            <h1 className="text-white mb-6 text-2xl font-bold">
                QR Code Scanner
            </h1>

            {/* Scanner Control Buttons */}
            <div className="mb-4">
                {!isScanning ? (
                    <button
                        onClick={handleStartScanner}
                        className="px-6 py-3 bg-green-500 text-white rounded-lg hover:bg-green-600 transition font-semibold shadow-lg"
                    >
                        Start Scanner
                    </button>
                ) : (
                    <button
                        onClick={handleStopScanner}
                        className="px-6 py-3 bg-red-500 text-white rounded-lg hover:bg-red-600 transition font-semibold shadow-lg"
                    >
                        Stop Scanner
                    </button>
                )}
            </div>
            
            <div id="reader" style={{ width: '500px', height: '500px' }}></div>

            {showPopup && (
                <div className="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                    <div className="bg-white rounded-lg p-6 max-w-md w-full mx-4">
                        <h2 className="text-xl font-bold mb-4">Scan Result</h2>
                        <div className="mb-4">
                            <p className="text-gray-700 break-all">{scannedCode}</p>
                        </div>
                        <div className="flex gap-2 justify-end">
                            <button
                                onClick={handleClosePopup}
                                className="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition"
                            >
                                Close
                            </button>
                            <button
                                onClick={handleScanAgain}
                                className="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition"
                            >
                                Scan Again
                            </button>
                        </div>
                    </div>
                </div>
            )}
        </main>
    );
}