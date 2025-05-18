import { ref, computed } from 'vue';
import { defineStore } from 'pinia';

interface ConnectedUser {
    email: string | null;
    role: string | null;
    id: number | null;
    statut: string | null;
}

export const useUserStore = defineStore('user', () => {
    const user = ref<ConnectedUser>({
        email: '',
        role: '',
        id: 0,
        statut: 'ok'
    });

    user.value.email = localStorage.getItem('email');
    user.value.role = localStorage.getItem('role');
    user.value.id = Number(localStorage.getItem('id'));
    user.value.statut = (localStorage.getItem('statut'));

    const islogged = computed(() => {
        return !!user.value.email;
    });

    function setUser(data: ConnectedUser) {
        user.value.email = data.email;
        user.value.role = data.role;
        user.value.id = data.id;
        user.value.statut = data.statut;

        localStorage.setItem('email', data.email ?? '');
        localStorage.setItem('role', data.role ?? '');
        localStorage.setItem('id', String(data.id ?? 0));
        localStorage.setItem('statut', data.statut ?? 'ok');
    }

    function clearUser() {
        setUser({
            email: '',
            role: '',
            id: 0,
            statut: '',
        })
    }

    return {
        user,
        islogged,
        setUser,
        clearUser
    };
});