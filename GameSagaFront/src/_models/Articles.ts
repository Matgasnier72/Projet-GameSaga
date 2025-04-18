export interface Article {
  id?: number;
  titre: string;
  created_at: string;
  contenu: string;
  note: number;
  author: any;
}

export interface SearchResponse {
  data: {
    post: Article[];
  };
}