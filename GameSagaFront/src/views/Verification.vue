<script setup lang="ts">
import { onMounted, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import * as VerificationService from '@/_services/VerificationService';

const route = useRoute();
const router = useRouter();

const verificationError = ref<string | null>(null);

async function verification(email: string, token: string) {
    try {
        await VerificationService.verification(email, token);
    } catch (error) {
        console.error('Erreur lors de la vérification de l\'e-mail :', error);
        verificationError.value = 'La vérification a échoué, veuillez réessayer plus tard.';
    }
}

onMounted(async () => {
    const email = route.query.email as string;
    const token = route.query.token as string;

    if (email && token) {
        await verification(email, token);
    } else {
        verificationError.value = 'Les paramètres nécessaires sont manquants.';
    }
});
</script>

<template>
    <main>
        <h1>Bienvenue !</h1>

        <!-- ERROR MESSAGE -->
        <div v-if="verificationError" class="alert-message">{{ verificationError }}</div>
        <p>Votre e-mail a bien été vérifié, vous pouvez dès à présent vous connecter avec vos identifiants.</p>
    </main>
</template>

<!-- <style scoped lang="scss">
main {
    background-image: url('/images/plante3.webp');
    background-position: top;
    background-size: cover;
    background-repeat: no-repeat;
    min-height: 85vh;
    height: auto;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: start;
    padding-left: 60px;

    h1 {
        margin-bottom: 40px;
    }

    p {
        font-size: 20px;
        color: #646464;
        max-width: 600px;
        line-height: 30px;
    }
}

@media (hover: none) and (pointer: coarse) and (max-width: 480px) {
    main {
        padding-left: 30px;
        min-height: 60vh;
    }
}
</style> -->