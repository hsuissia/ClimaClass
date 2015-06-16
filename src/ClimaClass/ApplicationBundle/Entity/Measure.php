<?php

namespace ClimaClass\ApplicationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Measure
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ClimaClass\ApplicationBundle\Entity\MeasureRepository")
 */
class Measure
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="temperature", type="float", scale=2, nullable=true)
     */
    private $temperature;

    /**
     * @var float
     *
     * @ORM\Column(name="wind_speed", type="float", scale=2, nullable=true)
     */
    private $windSpeed;

    /**
     * @var integer
     *
     * @ORM\Column(name="wind_direction", type="integer", nullable=true)
     */
    private $windDirection;

    /**
     * @var integer
     *
     * @ORM\Column(name="rain_level", type="integer", nullable=true)
     */
    private $rainLevel;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="measurement_date", type="datetime", nullable=true)
     */
    private $measurementDate;
    
    /**
     * @ORM\ManyToOne(targetEntity="Report", inversedBy="measures", cascade={"persist"})
     * @ORM\JoinColumn(name="id_report", referencedColumnName="id")
     **/
    private $report;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set temperature
     *
     * @param float $temperature
     * @return Measure
     */
    public function setTemperature($temperature)
    {
        $this->temperature = $temperature;

        return $this;
    }

    /**
     * Get temperature
     *
     * @return float 
     */
    public function getTemperature()
    {
        return $this->temperature;
    }

    /**
     * Set windSpeed
     *
     * @param float $windSpeed
     * @return Measure
     */
    public function setWindSpeed($windSpeed)
    {
        $this->windSpeed = $windSpeed;

        return $this;
    }

    /**
     * Get windSpeed
     *
     * @return float 
     */
    public function getWindSpeed()
    {
        return $this->windSpeed;
    }

    /**
     * Set windDirection
     *
     * @param integer $windDirection
     * @return Measure
     */
    public function setWindDirection($windDirection)
    {
        $this->windDirection = $windDirection;

        return $this;
    }

    /**
     * Get windDirection
     *
     * @return integer 
     */
    public function getWindDirection()
    {
        return $this->windDirection;
    }

    /**
     * Set rainLevel
     *
     * @param integer $rainLevel
     * @return Measure
     */
    public function setRainLevel($rainLevel)
    {
        $this->rainLevel = $rainLevel;

        return $this;
    }

    /**
     * Get rainLevel
     *
     * @return integer 
     */
    public function getRainLevel()
    {
        return $this->rainLevel;
    }

    /**
     * Set measurementDate
     *
     * @param \DateTime $measurementDate
     * @return Measure
     */
    public function setMeasurementDate($measurementDate)
    {
        $this->measurementDate = $measurementDate;

        return $this;
    }

    /**
     * Get measurementDate
     *
     * @return \DateTime 
     */
    public function getMeasurementDate()
    {
        return $this->measurementDate;
    }

    /**
     * Set report
     *
     * @param \ClimaClass\ApplicationBundle\Entity\Report $report
     * @return Measure
     */
    public function setReport(\ClimaClass\ApplicationBundle\Entity\Report $report = null)
    {
        $this->report = $report;

        return $this;
    }

    /**
     * Get report
     *
     * @return \ClimaClass\ApplicationBundle\Entity\Report 
     */
    public function getReport()
    {
        return $this->report;
    }
    
}
