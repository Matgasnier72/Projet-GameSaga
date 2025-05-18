export interface User {
    id: number;
    email: string;
    nom: string;
    prenom: string;
    avatar: string;
    pseudo: string;
    role: string;
    statut: string;
}
export interface UserStatut {
    id: number;
    statut: string;
}
export interface UserRole {
    id: number;
    role: string;
}