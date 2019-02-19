<?php
namespace poi_api\Model;


use poi_api\Model\City;
use Doctrine\ORM\Mapping as ORM;

/**
 * Poi
 *
 * @ORM\Table(name="poi", uniqueConstraints={@ORM\UniqueConstraint(name="id_poi_UNIQUE", columns={"id_poi"})}, indexes={@ORM\Index(name="fk_idcity_city_idx", columns={"id_city"})})
 * @ORM\Entity
 */
class Poi
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_poi", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPoi;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=30, precision=0, scale=0, nullable=false, unique=false)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="string", length=100, precision=0, scale=0, nullable=true, unique=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=30, precision=0, scale=0, nullable=false, unique=false)
     */
    private $type;

    /**
     * @var float
     *
     * @ORM\Column(name="latitude", type="float", precision=10, scale=0, nullable=false, unique=false)
     */
    private $latitude;

    /**
     * @var float
     *
     * @ORM\Column(name="longitude", type="float", precision=10, scale=0, nullable=false, unique=false)
     */
    private $longitude;

    /**
     * @var City
     *
     * @ORM\ManyToOne(targetEntity="City")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_city", referencedColumnName="id_city", nullable=true)
     * })
     */
    private $idCity;


    /**
     * Get idPoi.
     *
     * @return int
     */
    public function getIdPoi()
    {
        return $this->idPoi;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Poi
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description.
     *
     * @param string|null $description
     *
     * @return Poi
     */
    public function setDescription($description = null)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set type.
     *
     * @param string $type
     *
     * @return Poi
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set latitude.
     *
     * @param float $latitude
     *
     * @return Poi
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude.
     *
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude.
     *
     * @param float $longitude
     *
     * @return Poi
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude.
     *
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set idCity.
     *
     * @param City|null $idCity
     *
     * @return Poi
     */
    public function setIdCity(City $idCity = null)
    {
        $this->idCity = $idCity;

        return $this;
    }

    /**
     * Get idCity.
     *
     * @return City|null
     */
    public function getIdCity()
    {
        return $this->idCity;
    }
}
