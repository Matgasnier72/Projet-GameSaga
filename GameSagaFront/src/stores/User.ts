import { ref, computed } from 'vue';
import { defineStore } from 'pinia';

interface ConnectedUser {
    email: string | null;
    role: string | null;
}

export const useUserStore = defineStore('user', () => {
    const user = ref<ConnectedUser>({
        email: '',

        role: ''
    });

    user.value.email = localStorage.getItem('email');
    user.value.role = localStorage.getItem('role');
const islogged =computed(()=>{
    return !!user.value.email;
});

function setUser(data: ConnectedUser){
    user.value.email = data.email;
    user.value.role = data.role;
    localStorage.setItem('email',data.email ?? '');
    localStorage.setItem('role',data.role ?? '');
}

function clearUser(){
    setUser({
        email: '',
        role: ''
    })
}

return{
    user,
    islogged,
    setUser,
    clearUser
};
});