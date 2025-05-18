import type { User } from '@/_models/User';
export interface ArticleBase{
    titre: string;
    contenu: string;
    note_auteur : number;
    id :number;
    
}

export  interface Article extends ArticleBase{
  
  status: string;
  created_at: string;
  image:string;
  author: User;
}

export interface ArticleCreate extends ArticleBase{
  image_blob: Blob | null;
    user_id : number;

}
export interface SearchResponse {
  data: {
    post: Article[];
  };
}