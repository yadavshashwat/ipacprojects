import { Url } from "./url";
export interface UploadFotosResponse {
    status: string;
    msg: string;
    counter: number;
    results: Array<Url>;
}
