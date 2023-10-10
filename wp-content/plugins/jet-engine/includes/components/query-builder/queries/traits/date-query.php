<?php
namespace Jet_Engine\Query_Builder\Queries\Traits;

trait Date_Query_Trait {

	/**
	 * Prepare Date Query arguments by initial arguments list
	 *
	 * @param   array $args
	 * @return array
	 */
	public function prepare_date_query_args( $args = array() ) {

		$raw        = $args['date_query'];
		$date_query = array();

		foreach ( $raw as $query_row ) {

			if ( empty( $query_row['year'] ) ) {
				unset( $query_row['year'] );
			}

			if ( ! empty( $query_row['year'] )
				 || ! empty( $query_row['month'] )
				 || ! empty( $query_row['day'] )
				 || ! empty( $query_row['after'] )
				 || ! empty( $query_row['before'] )
			) {
				$date_query[] = $query_row;
			}
		}

		return $date_query;
	}

}
