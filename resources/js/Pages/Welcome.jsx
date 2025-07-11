import { Link, Head } from '@inertiajs/react';
import { useState } from 'react';

export default function Welcome({ auth, laravelVersion, phpVersion, data }) {
    const [prodi, setProdi] = useState('');

    const handleChangeProdi = (prodi) =>{
        console.log(prodi);
        setProdi(prodi);
    }
    
    return (
        <>
            <Head title="Welcome" />
            
            <div className="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
                <div className="sm:fixed sm:top-0 sm:right-0 p-6 text-end">
                    {auth.user ? (
                        <Link
                            href={route('dashboard')}
                            className="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                        >
                            Dashboard
                        </Link>
                    ) : (
                        <>
                            <Link
                                href={route('login')}
                                className="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                            >
                                Log in
                            </Link>

                            <Link
                                href={route('register')}
                                className="ms-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                            >
                                Register
                            </Link>
                        </>
                    )}
                </div>

                <div className="max-w-7xl mx-auto p-6 lg:p-8 w-full">
                {!prodi && (
                    <>
                    <div className='flex row justify-center mb-6 gap-4'>
                        <a href="#" onClick={() => handleChangeProdi('informatika')} className="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                            Informatika
                        </a>
                        <a href="#" onClick={() => handleChangeProdi('Sistem Informasi')} className="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                            Sistem Informasi
                        </a>
                        <a href="#" onClick={() => handleChangeProdi('Teknik Industri')} className="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                           Teknik Industri
                        </a>
                    </div>
                    <div className='flex row justify-center mb-6 gap-4'>
                        <a href="#" onClick={() => handleChangeProdi('Arsitektur')} className="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                            Arsitektur
                        </a>
                        <a href="#" onClick={() => handleChangeProdi('Teknik Biomedik')} className="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                            Teknik Biomedik
                        </a>
                        <a href="#" onClick={() => handleChangeProdi('Ilmu Keolahragaan')} className="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                           Ilmu Keolahragaan
                        </a>
                    </div>
                    <div className='flex row justify-center mb-6 gap-4'>
                        <a href="#" onClick={() => handleChangeProdi('Gizi')} className="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                            Gizi
                        </a>
                        <a href="#" onClick={() => handleChangeProdi('Teknik Rekayasa elektromedis')} className="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                            Teknik Rekayasa elektromedis
                        </a>
                        <a href="#" onClick={() => handleChangeProdi('Farmasi')} className="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                           Farmasi
                        </a>
                    </div>
                    </>
                )}
                    
                    {prodi && (
                            <div className="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                                <h2 className="text-center mt-6 text-xl font-bold text-gray-900 dark:text-white">
                                    Jadwal Hari Ini
                                </h2>
                                {/* <h2 className="text-center mt-6 text-xl font-bold text-gray-900 dark:text-white">
                                    {prodi ? prodi.toUpperCase() : '-'}
                                </h2> */}

                                {Object.entries(data).map(([key, value], idx) => {
                                    if(key.toLowerCase().replace(/\s+/g, '') !== prodi.toLowerCase().replace(/\s+/g, '')) return null; // Filter by selected prodi
                                    return(
                                        <div key={key} className='mt-6 '>
                                            <hr />
                                            <h2 className="text-center mt-2 text-l font-semibold text-gray-600 dark:text-white">
                                                {key}
                                            </h2>
                                            <table className="w-full mt-2 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                                <thead>
                                                    <tr>
                                                        <th>Kelas</th>
                                                        <th>Ruangan</th>
                                                        <th>Jam Masuk</th>
                                                        <th>Jam Akhir</th>
                                                        <th>Mata Kuliah</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    {Array.isArray(value) && value.map((item, idx) => (
                                                            <tr className='text-center' key={idx}>
                                                                <td>{item.class_name}</td>
                                                                <td>{item.room_name}</td>
                                                                <td>{item.start_time}</td>
                                                                <td>{item.end_time}</td>
                                                                <td>{item.subject_name}</td>
                                                            </tr>
                                                    ))}
                                                </tbody>
                                            </table>
                                        </div>
                                        )
                                })}
                            </div>
                    )}

                    <div className="flex justify-center mt-16 px-6 sm:items-center sm:justify-between">
                        <div className="ms-4 text-center text-sm text-gray-500 dark:text-gray-400 sm:text-end sm:ms-0">
                            Copyright@2024
                        </div>
                    </div>
                </div>
            </div>

            <style>{`
                .bg-dots-darker {
                    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
                }
                @media (prefers-color-scheme: dark) {
                    .dark\\:bg-dots-lighter {
                        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
                    }
                }
            `}</style>
        </>
    );
}
