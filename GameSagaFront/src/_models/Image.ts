export interface ImageBase{
    description: string;
    nom: string;
    article_id : number;
}
export interface ImagePost extends ImageBase{
    image_blob: Blob | null;
}

export interface Image extends ImageBase{
    id: number;
    statut: string;
    path: string;
}