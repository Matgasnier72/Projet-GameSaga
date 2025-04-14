import type { User } from '@/_models/User';
export interface Article{
    id? :number;
    titre: string;
    contenu: string;
    created_at: string;
    note_auteur : number;
    user_id? : number;
    author?: User;
}
export interface SearchResponse {
  data: {
    post: Article[];
  };
}