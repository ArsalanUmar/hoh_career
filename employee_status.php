<?php

const EMPLOYEE_STATUS_ACTIVE = 'active';
const EMPLOYEE_STATUS_MARK_TO_ARCH = 'mark_to_arch';
const EMPLOYEE_STATUS_ARCHIVED = 'archived';

function employee_is_active($employee)
{
    return !empty($employee)
        && isset($employee['status'])
        && $employee['status'] === EMPLOYEE_STATUS_ACTIVE;
}
