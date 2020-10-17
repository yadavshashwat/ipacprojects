/**
 * @author victor
 */
import { MediaReadWriteKey } from "./media-read-write-key";
export interface UserMediaModel {
    name: string;
    is_media: boolean;
    media_read_write: MediaReadWriteKey;
    id: string;
    is_admin: boolean;
    is_media_admin: boolean;
    email: string;
    is_media_write: true;
}

