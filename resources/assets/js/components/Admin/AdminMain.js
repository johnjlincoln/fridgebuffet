import React from 'react'
import PropTypes from 'prop-types';

const AdminMain = props => (
    <div>
        <button onClick={props.handleTest}>Activate Lasers</button>
    </div>
)

AdminMain.propTypes = {
    handleTest: PropTypes.func
}

AdminMain.defaultProps = {
    //
};

export default AdminMain;
