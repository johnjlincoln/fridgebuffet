import React from 'react'
import PropTypes from 'prop-types';

const test = () => {
    console.log('flerp');
};

const AdminDisplay = props => (
    <div className="container">
        <div className="row justify-content-center">
            <div className="col-md-8">
                <div className="card">
                    <div className="card-header">Admin Dashboard</div>
                    <div className="card-body">
                        <button onClick={test}>Activate Lasers</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
)

AdminDisplay.propTypes = {
    handleTest: PropTypes.func
}

AdminDisplay.defaultProps = {
    //
};

export default AdminDisplay;
