export interface Article {
    titre: string;
  }
  
  export interface SearchResponse {
    data: {
      post: Article[];
    };
  }