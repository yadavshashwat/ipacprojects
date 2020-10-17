import { ResultAuth } from "../media-dashboard/result-auth";
import { UserMediaModel } from "../media-dashboard/user-media-model";
export interface UserResponse {
    status: boolean;
    message: string;
    result: ResultAuth;
    user: UserMediaModel | {};
}
