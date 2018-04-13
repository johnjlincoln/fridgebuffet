import React from 'react'
import PropTypes from 'prop-types';

const AdminDisplay = props => (
    <div>
        <button onClick={props.handleTest}>Activate Lasers</button>
    </div>
)

AdminDisplay.propTypes = {
    handleTest: PropTypes.func
}

AdminDisplay.defaultProps = {
    //
};

export default AdminDisplay;
