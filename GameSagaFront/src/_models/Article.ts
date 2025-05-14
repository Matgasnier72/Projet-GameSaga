import type { User } from '@/_models/User';
export interface ArticleBase{
    titre: string;
    contenu: string;
    note_auteur : number;
    
}

export  interface Article extends ArticleBase{
  id :number;
  status: string;
  created_at: string;
  image:string;
  user_id : number;
  author: User;
}

export interface ArticleCreate extends ArticleBase{
  image_blob: Blob | null;
}
export interface SearchResponse {
  data: {
    post: Article[];
  };
}