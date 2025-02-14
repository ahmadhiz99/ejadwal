import ButtonLink from "@/Components/ButtonLink";
import PrimaryButton from "@/Components/PrimaryButton";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, router, usePage } from "@inertiajs/react";
import { formToJSON } from "axios";
import { ToastContainer, toast } from "react-toastify";

export default function Lecturers({ auth }) {
    const data = usePage().props.data.original.data;

    const detail = (e, id) => {
        e.preventDefault();
        router.visit(`/user-show/${id}`, {
            method: "get",
            // data: {
            //     user_name: userName,
            //     description: description,
            // },
        });
    };
    const deleteData = (e, id) => {
        e.preventDefault();
        router.visit(`/user-destroy/${id}`, {
            method: "delete",
            // onSuccess: () => {
            //     toast.success("Berhasil hapus!");
            // },
        });
    };
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Dosen
                </h2>
            }
        >
            <Head title="Lecturer" />

            <ToastContainer
                position="top-right"
                autoClose={5000}
                hideProgressBar={false}
                newestOnTop={false}
                closeOnClick
                rtl={false}
                pauseOnFocusLoss
                draggable
                pauseOnHover
                theme="light"
                transition={true}
            />

            <div className="py-8">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                        <div className="p-6 text-gray-900">
                            <div className="page-head flex flex-row justify-between items-center">
                                <h1 className="text-xl font-bold">
                                    Dosen
                                </h1>
                                <ButtonLink href={"user.create"}>
                                    Tambah Baru
                                </ButtonLink>
                            </div>
                        </div>
                    </div>
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            <div className="content">
                                <table className="w-full">
                                    <thead className="bg-sky-800 text-white">
                                        <tr>
                                            <th className="py-3 px-8 w-5 text-center">
                                                No
                                            </th>
                                            <th className="w-1/4 text-center">
                                                Name
                                            </th>
                                            <th className="w-1/4 text-left">
                                                Email
                                            </th>
                                            <th className="w-1/4 text-left">
                                                Role
                                            </th>
                                            <th className="w-1/4 text-left">
                                                Program Study
                                            </th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {data.data
                                            ? data.data.map((user, idx) => {
                                                  return (
                                                      <tr
                                                          key={user.id}
                                                          className="border text-gray-700"
                                                      >
                                                          <td className="px-8 py-8 text-center">
                                                              {idx + 1}
                                                          </td>
                                                          <td className="text-center">
                                                              {user.name}
                                                          </td>
                                                          <td className="text-center">
                                                              {user.email}
                                                          </td>
                                                          <td className="text-center">
                                                              {user.role_name}
                                                          </td>
                                                          <td className="text-center">
                                                              {user.prodi_name}
                                                          </td>

                                                        
                                                          <td>
                                                              <div className="flex flex-row items-center justify-center gap-2">
                                                                  <i
                                                                      onClick={(
                                                                          e
                                                                      ) =>
                                                                          detail(
                                                                              e,
                                                                              user.id
                                                                          )
                                                                      }
                                                                      className="bx bx-fw bx-info-circle"
                                                                  ></i>
                                                                  <i
                                                                      onClick={(
                                                                          e
                                                                      ) =>
                                                                          deleteData(
                                                                              e,
                                                                              user.id
                                                                          )
                                                                      }
                                                                      className="bx bx-fw bx-trash text-rose-500"
                                                                  ></i>
                                                              </div>
                                                          </td>
                                                      </tr>
                                                  );
                                              })
                                            : ""}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
