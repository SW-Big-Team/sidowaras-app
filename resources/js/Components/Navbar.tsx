import { useForm } from "@inertiajs/react";
import {
    Button,
    Card,
    Modal,
    ModalBody,
    ModalContent,
    ModalFooter,
    ModalHeader,
    useDisclosure,
    Link
} from "@heroui/react";
import { useRoute } from "ziggy-js";

export default function NavbarComponent() {
    const route = useRoute();
    const {isOpen, onOpen, onOpenChange} = useDisclosure();
    // const { data, setData, post, processing, errors, reset } = useForm({
    //     logout: '',
    // });

    // const logoutAction = () => {
    //     post(route("logout"));
    // };

    return (
        <div className="flex w-full justify-center items-center">
            <Card 
                isBlurred
                className="flex flex-row justify-between items-center w-4/5 border-none bg-slate-200 my-3 px-8 py-4 rounded-3xl"
                >
                <h1 className="">
                    Sidowaras
                </h1>
                <Button
                    onPress={onOpen}
                    color="danger"
                    variant="shadow"
                    >
                    Logout
                </Button>
                <Modal 
                    isOpen={isOpen}
                    onOpenChange={onOpenChange}
                >
                    <ModalContent className="bg-slate-200/80">
                        {(onClose) => (
                            <>
                            <ModalHeader>Logout?</ModalHeader>
                            <ModalBody>
                                <p>
                                    Are you sure you want to logout?
                                </p>
                            </ModalBody>
                            <ModalFooter>
                                <Button
                                    onPress={onClose}
                                    color="success"
                                    variant="shadow"
                                    >
                                    Cancel
                                </Button>
                                <Button
                                    as={Link}
                                    // onPress={logoutAction}
                                    color="danger"
                                    variant="shadow"
                                    >
                                    Logout
                                </Button>
                            </ModalFooter>
                            </>
                        )}
                    </ModalContent>
                </Modal>
            </Card>
        </div>
    );
}