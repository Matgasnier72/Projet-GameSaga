import type{ User } from "@/_models/User";
import type{ Article } from "@/_models/Article";

export interface CommentaireBase{
    id?: number;
    status?: string;
}

export interface Commentaire extends CommentaireBase{
    article_id?: number;
    contenu: string;
    note: number;
    created_at: string;
    user?: User
    article?: Article;
}

