import useHttpRequest from './useHttpRequest';
import useUserStore from '../store/useUserStore';

const useAuth = () => {
    const userStore = useUserStore();
    const { index: verify } = useHttpRequest('/auth/verify');

    const isUserAuthenticated = async () => {
        const user = await verify();
        if (!Array.isArray(user) && user?.id) {
            userStore.setUser(user);
            return true;
        }
        return false;
    };

    return {
        isUserAuthenticated,
    };
};

export default useAuth;
