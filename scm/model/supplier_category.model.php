<?php
/**
 * ��Ʒ�������
 */
defined('InShopNC') or exit('Access Invalid!');
class supplier_categoryModel extends Model {

    /**
     *
     *�����Ʒ����
     * @param   array $category ҵ��Ա��Ϣ
     * @return  array �����ʽ�ķ��ؽ��
     */
    public function addCategory($category) {
        if(empty($category)) {
            return false;
        }
        try {
            $this->beginTransaction();
            $insert_id  = $this->table('scm_supp_category')->insert($category);
            if (!$insert_id) {
                throw new Exception();
            }
            $this->commit();
            return $insert_id;
        } catch (Exception $e) {
            $this->rollback();
            return false;
        }
    }

    /**
     * ��ȡ������Ϣ
     * @param array $condition ��ѯ����, array $field ɸѡ��
     * @return array �����ʽ���ز�ѯ���
     */
    public function getCategoryInfo($condition , $field = '*'){
        return $this->table('scm_supp_category')->field($field)->where($condition)->find();
    }

    /**
     * ��������ȡ�����б�
     * @param $condition ��ѯ����, array $field ɸѡ��
     * @return array �����ʽ���ز�ѯ���
     */
    public function getCategoryList($condition = array(), $field = '*',$order = 'sort asc'){
        return $this->table('scm_supp_category')->field($field)->where($condition)->order($order)->select();
    }

    /**
     * ��ȡ���������
     * @param $condition
     */
    public function getCategoryCount($condition){
        return $this->table('scm_supp_category')->where($condition)->count();
    }
    /**
     * ������Ʒ�������ϸ��Ϣ
     *
     * @param array $update_category
     * @param int $id
     * @return bool
     */
    public function updateCategory($update_category){
        $update_id = $this->table('scm_supp_category')->where(array('cate_id'=>$update_category["cate_id"]))->update($update_category);
        if($update_id)
            return true;
        else
            return false;
    }
}