import type{ User } from "@/_models/User";
import type{ Article } from "@/_models/Article";

export interface Commentaire {
    id?: number;
    article_id?: number;
    contenu: string;
    note: number;
    created_at: string;
    status?: string;
    user?: User
    article?: Article;
}