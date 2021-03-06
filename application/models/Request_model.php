<?php
require_once APPPATH.'models/daos/Request_dao.php';

class Request_model extends CI_Model {
    private $id;
    private $kind;
    private $status;
    private $instructions;
    private $reason;
    private $created_at;
    private $deleted_at;
    private $user;
    private $indicator;

    public function __construct($id=NULL, $kind=NULL, $status=NULL, $instructions=NULL,
                                $reason=NULL, $create_at=NULL, $user=NULL, $indicator=NULL, $deleted_at=NULL) {
        parent::__construct();
        $this->id = $id;
        $this->kind = $kind;
        $this->status = $status;
        $this->instructions = $instructions;
        $this->reason = $reason;
        $this->created_at = $create_at;
        $this->user = $user;
        $this->indicator = $indicator;
        $this->deleted_at = $deleted_at;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getKind() {
        return $this->kind;
    }

    public function setKind($kind) {
        $this->kind = $kind;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function getInstructions() {
        return $this->instructions;
    }

    public function setInstructions($instructions) {
        $this->instructions = $instructions;
    }

    public function getReason() {
        return $this->reason;
    }

    public function setReason($reason) {
        $this->reason = $reason;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    public function setCreatedAt($created_at) {
        $this->created_at = $created_at;
    }

    public function getDeletedAt() {
        return $this->deleted_at;
    }

    public function setDeletedAt($deleted_at) {
        $this->deleted_at = $deleted_at;
    }

    public function getUser() {
        return $this->user;
    }

    public function setUser($user) {
        $this->user = $user;
    }

    public function getRequesterName() {
        return $this->getUser()->last_name.' '.$this->getUser()->first_name;
    }

    public function getIndicator() {
        return $this->indicator;
    }

    public function setIndicator($indicator) {
        $this->indicator = $indicator;
    }

    public function destroy($request) {
        $request_dao = new Request_dao();
        return $request_dao->delete($request->getId());
    }

    public function soft_destroy($request) {
        $request_dao = new Request_dao();
        $request->setDeletedAt(date('Y-m-d h:i:sa', time()));
        return $request_dao->update($request);
    }

    public static function getRequestsSummary() {
        $request_dao = new Request_dao();

        $summary['TOTAL'] = count($request_dao->get());

        $summary['TOTAL_EDIT'] = count($request_dao->get(array(Request_dao::KIND_FIELD => 'EDIT')));
        $summary['TOTAL_EDIT_PENDING'] = count($request_dao->get(array(
            Request_dao::KIND_FIELD => 'EDIT', Request_dao::STATUS_FIELD => 'PENDING')));
        $summary['TOTAL_EDIT_ACCEPTED'] = count($request_dao->get(array(
            Request_dao::KIND_FIELD => 'EDIT', Request_dao::STATUS_FIELD => 'ACCEPTED')));

        $summary['TOTAL_ARCHIVE'] = count($request_dao->get(array(Request_dao::KIND_FIELD => 'ARCHIVE')));
        $summary['TOTAL_ARCHIVE_PENDING'] = count($request_dao->get(array(
            Request_dao::KIND_FIELD => 'ARCHIVE', Request_dao::STATUS_FIELD => 'PENDING')));
        $summary['TOTAL_ARCHIVE_ACCEPTED'] = count($request_dao->get(array(
            Request_dao::KIND_FIELD => 'ARCHIVE', Request_dao::STATUS_FIELD => 'ACCEPTED')));

        return $summary;
    }
}