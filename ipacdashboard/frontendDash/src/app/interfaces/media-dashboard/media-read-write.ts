/**
 * @author victor
 */
export interface MediaReadWrite {
    read: boolean;
    segmentation_id: string;
    segment_active: boolean;
    write: boolean;
    segment_name: string;
    segmentation_type: string;
}
